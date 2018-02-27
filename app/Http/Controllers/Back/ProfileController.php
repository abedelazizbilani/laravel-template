<?php

namespace App\Http\Controllers\Back;

use App\Base\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Country;
use App\Models\Profile;
use App\Models\User;
use App\Repositories\ProfileRepository;
use App\Traits\Indexable;

class ProfileController extends BaseController
{
    use Indexable;

    /**
     * Create a new ProfileController instance.
     *
     * @param  \App\Repositories\ProfileRepository $repository
     */
    public function __construct(ProfileRepository $repository)
    {
        $this->repository = $repository;

        $this->table = 'profiles';
    }

    public static function validationRules()
    {
        return [];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Profile $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        if(!$profile){
            $ProfileInputs['user_id'] = Auth::user()->id;
            $profile = Profile::create($ProfileInputs);
        }

        $countries = Country::with("translations")->get();
        $countryEn = "";
        foreach ($countries as $country){
            foreach ($country->translations as $name){
                if($name->locale == "en"){
                    $countryEn = $name->name;
                }
            }
            $countryList[$country->id] = $countryEn;
        }

        return view('back.profiles.edit', compact('profile', 'countryList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ProfileUpdateRequest $request
     * @param  \App\Models\Profile $profile
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileUpdateRequest $request, Profile $profile)
    {
        $file = $request->file('image');
        if($file){
            $profile->saveUserProfileImage($file);
        }

        $this->repository->update($request, $profile);

        return back()->with('role-updated', __('The role has been successfully updated'));
    }
}
