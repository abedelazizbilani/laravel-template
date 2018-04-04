<?php


namespace App\Http\Response;

use Illuminate\Http\JsonResponse;

class Response extends JsonResponse
{
    const STATUS_SUCCESS = 'success';
    const STATUS_FAILED = 'failed';
    const STATUS_ERROR = 'error';
    const STATUS_UNAUTHORIZED = 'unauthorized';

    private $status;
    private $message;
    private $rData = [];
    private $rHeader = [];
    private $alert = [];
    private $finalData = [];

    public function generate($httpStatus = 200)
    {
        $this->status  = $this->status ? $this->status : static::STATUS_SUCCESS;
        $this->message = $this->message ? $this->message : static::STATUS_SUCCESS;

       $this->finalData = $this->finalData + [
                 'status'  => $this->status,
                 'message' => $this->message,
       ];

        if ( ! empty($this->rData)) {
            $this->finalData =  $this->finalData + ['data' => $this->rData];
        }
        if ( ! empty($this->alert)) {
            $this->finalData =  $this->finalData + ['alert' => $this->alert];
        }

        return parent::create(
            $this->finalData,
            $httpStatus,
            $this->rHeader
        );
    }

    public function updateResponseTemplate($key,$value){
        $this->finalData = $this->finalData + [$key => $value];
    }

    public function updateData($data)
    {
        $this->rData = $data;

        return $this;
    }

    public function setHeader($headerData)
    {
        $this->rHeader = $headerData;

        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    public function setMessage($message)
    {
        $this->message = trans($message);

        return $this;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function addData($key, $value)
    {
        $this->rData[$key] = $value;

        return $this;
    }

    public function setAlert($title = "", $message = "")
    {
        $this->setAlertTitle($title);
        $this->setAlertMessage($message);
    }

    public function setAlertTitle($title)
    {
        $this->alert["title"] = trans($title);
    }

    public function setAlertMessage($message)
    {
        $this->alert["message"] = trans($message);
    }

    public function fillDataAndMessage($message = null, $data = null)
    {
        if ($message) {
            $this->setMessage($message);
        }
        if ($data) {
            $this->updateData($data);
        }
    }

    public function success($message = null, $data = null)
    {
        $this->fillDataAndMessage($message, $data);
        $this->setStatus(static::STATUS_SUCCESS);

        return $this->generate(200);
    }

    public function failed($message = null, $data = null)
    {
        $this->fillDataAndMessage($message, $data);
        $this->setStatus(static::STATUS_FAILED);

        return $this->generate(200);
    }

    public function error($message = "error", $data = null)
    {
        $this->setStatus(static::STATUS_ERROR);

        if ( ! empty($data)) {
            $data = ['errors' => $data];
        }

        $this->fillDataAndMessage($message, $data);

        return $this->generate(500);
    }

    public function bad($message = null, $data = null)
    {
        $this->fillDataAndMessage($message, $data);

        return $this->generate(400);
    }

    public function unauthorized($message = null, $data = null)
    {
        $this->setStatus(static::STATUS_UNAUTHORIZED);
        $this->fillDataAndMessage($message, $data);

        return $this->generate(401);
    }

    public function forbidden($message = null, $data = null)
    {
        $this->fillDataAndMessage($message, $data);

        return $this->generate(401);
    }

    public function notFound($message = null, $data = null)
    {
        $this->fillDataAndMessage($message, $data);

        return $this->generate(401);
    }

    public function deleted($message = null, $data = null)
    {
        $this->fillDataAndMessage($message, $data);

        return $this->generate(204);
    }

}