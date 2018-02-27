<?php

/*
 * This file is part of the IdeaToLife package.
 *
 * (c) Youssef Jradeh <youssef.jradeh@ideatolife.me>
 *
 */

namespace App\Base;

use App\Helpers\Paging;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

/**
 * Eloquent Model Base class
 */
Abstract class BaseCrud extends BaseController
{
    /*
     * @var \Idea\Base\BaseModel
     */
    protected $model;
    public $with = [];
    public $withUpdate = [];//relation to be update
    public $withImage = false;
    public $withImageThumb = false;
    public $imageName = "image";
    public $thumbnailName = "thumbnail";
    public $filePath = "";
    public $defaultOrderBy = "created_at";
    public $defaultOrderType = "DESC";
    public $orderByTranslation = false;

    public $messages
        = [
            "destroy_error"   => "Cannot delete record",
            "destroy_success" => "Record deleted successfully",
            "save_error"      => "Cannot add record",
            "save_success"    => "Record added successfully",
        ];

    public function getModel()
    {
        return $this->model;
    }

    public function setModel($model)
    {
        $this->model = $model;
    }

    /**
     * paginates the records
     */
    public function index()
    {
        $query = $this->model;

        //set default Order

        if ($this->orderByTranslation) {
            $query = $query->orderByTranslation($this->defaultOrderBy, $this->defaultOrderType);
        } else {
            $query = $query->orderBy($this->defaultOrderBy, $this->defaultOrderType);
        }

        $query = $query->with($this->with);
        //if it is a search request
        if ($keyword = request("keyword")) {
            //scopeByKeyword should be added to the model
            $query->byKeyword($keyword);
        }

        if ($criteria = request("criteria")) {

            foreach ($criteria AS $key => $value) {

                if (empty($key) || empty($value)) {
                    continue;
                }
                //catch the operator if exist
                $options = explode("---", $value);
                if (empty($options['1'])) {
                    $options['1'] = "=";
                }
                //create the where

                $query->where($key, $options['1'], $options['0']);
            }
        }

        return $this->successData(new Paging($query));
    }

    /**
     * get one record
     */
    public function one($id)
    {
        $model = $this->model->with($this->with)->find($id);
        if ( ! $model) {
            return $this->failed('record_not_exist');
        }

        return $this->successData($model);
    }


    /**
     * Delete a Model
     */
    public function destroy($id)
    {
        if ( ! $this->validateId($id)) {
            return $this->failed('record_not_exist');
        }

        try {
            //delete image if exist
            $this->deleteImage();

            //then delete the row from the database
            $this->model->delete();

            return $this->success($this->messages['destroy_success']);
        } catch (\Exception $e) {
            return $this->failed($this->messages['destroy_error']);
        }
    }

    /**
     * save a Model
     */
    public function store()
    {
        if ( ! $this->save()) {
            return $this->failed($this->messages['save_error']);
        }

        return $this->success($this->messages['save_success'], $this->getModel());
    }

    /**
     * update Model
     * @param $id
     * @return mixed
     */
    public function update($id)
    {
        if ( ! $this->validateId($id)) {
            return $this->failed('record_not_exist');
        }

        if ( ! $this->save()) {
            return $this->failed($this->messages['save_error']);
        }

        return $this->success($this->messages['save_success'], $this->getModel());
    }

    protected function validateId($id)
    {
        if ( ! $model = $this->getModel()->find($id)) {
            return false;
        }
        $this->setModel($model);

        return true;
    }

    /**
     * save a Model
     */
    protected function save()
    {
        $data = $this->request->all();

        if (empty($data)) {
            return false;
        }

        if ($this->withImage) {
            $this->attachImage();
            unset($data[$this->imageName]);
        }

        foreach ($data AS $key => $value) {
            if ($value == "null") {
                $this->model->{$key} = null;
            } elseif ( ! is_array($value)) {
                $this->model->{$key} = $value;
            }
        }

        $this->insertTranslations($data);

        if ( ! $this->model->save()) {
            return false;
        }

        //update table relations
        $this->UpdateRelationsData($data);

        return $this->model;
    }

    /**
     * insert new translations.
     */
    protected function insertTranslations(&$data)
    {
        if (empty($data['translations'])) {
            return;
        }
        $translations = $data['translations'];

        //if update
        if ($this->model->id) {
            $this->model->deleteTranslations();
        }
        foreach ($translations AS $locale => $translation) {
            //remove frogein key like category_id or item_id or course_id
            unset($translation[$this->model->getRelationKey()]);

            //loop on each fields
            foreach ($translation AS $key => $value) {
                //add new model translation record
                $this->model->translateOrNew($locale)->{$key} = $value;
                //remove the field from the data if it is sent too
                unset($data[$key]);
            }
        }

        unset($data['translations']);

        return true;
    }

    /**
     * @param $user
     * @param $look
     *
     * @return array
     */
    protected function attachImage()
    {
        //validate the request
        if ( ! $this->request->hasFile($this->imageName)) {
            return false;
        }
        //remove existing image
        $this->deleteImage();

        $file = $this->request->{$this->imageName};
        $this->validate($this->request, [$this->imageName => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048']);


        //get file path
        $filePath = $this->getFilePath();

        //Set public folder path
        $folderPath = public_path($filePath);

        //renaming the file
        $name = time().'_'.rand(5000, 100000).".".$file->getClientOriginalExtension();

        //move the temporary file to the user folder with the name name
        if ( ! $file->move($folderPath, $name)) {
            return false;
        }

        //resize image quality
        Image::make($folderPath.$name)->resize(
            700,
            null,
            function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            }
        )->save($folderPath.$name, 75);

        if ($this->withImageThumb) {
            //thumbnail file name
            $thumbName = "thumb_".$name;

            //creating a thumbnail image
            Image::make($folderPath.$name)->resize(
                200,
                null,
                function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                }
            )->save($folderPath.$thumbName, 60);

            //update permission
            chmod($folderPath.$thumbName, 0777);

            $this->model->{$this->thumbnailName} = $filePath.$thumbName;
        }

        chmod($folderPath.$name, 0777);
        $this->model->{$this->imageName} = $filePath.$name;

        return true;
    }


    /**
     * Delete a Model
     */
    public function removeImage($id)
    {
        if ( ! $this->validateId($id) || ! $this->deleteImage()) {
            return $this->failed('cannot_remove_image');
        }

        return $this->success();
    }

    protected function deleteImage()
    {
        //if not image return back
        if ( ! $this->withImage || ! $this->model->{$this->imageName}) {
            return false;
        }

        //remove image file from the hard disk
        $existingImage = public_path($this->model->{$this->imageName});

        if (is_file($existingImage)) {
            unlink($existingImage);
        }
        $this->model->{$this->imageName} = "";

        //check Thumbnail
        if ($this->withImageThumb && $this->model->{$this->thumbnailName}) {
            $existingThumImage = public_path($this->model->{$this->thumbnailName});
            if (is_file($existingThumImage)) {
                unlink($existingThumImage);
            }
            $this->model->{$this->thumbnailName} = "";
        }

        //updating the record
        $this->model->save();

        return true;
    }

    /**
     * @return string
     */
    public function getFilePath(): string
    {
        $value = $this->filePath;

        //Replace user id if exist
        if ($user = Auth::user()) {
            $value = str_replace("{user_id}", $user->id, $value);
        }

        return $value;
    }

    /**
     * @param $data
     * @return bool
     */
    protected function UpdateRelationsData($data)
    {
        if (empty($this->withUpdate)) {
            return true;
        }

        foreach ($this->withUpdate as $relation) {
            //remove existing relations
            $this->model->{$relation}()->detach();
            if (empty($data[$relation]) || ! is_array($data[$relation])) {
                continue;
            }

            //it will only work on belongsToMany for now
            foreach ($data[$relation] as $item) {
                $this->model->{$relation}()->attach($item);
            }
        }

        return true;
    }
}