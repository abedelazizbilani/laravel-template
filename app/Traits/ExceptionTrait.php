<?php

/*
 * This file is part of the IdeaToLife package.
 *
 * (c) Youssef Jradeh <youssef.jradeh@ideatolife.me>
 *
 */

namespace App\Traits;

use App\Http\Response\Response;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

/**
 * ExceptionTrait
 */
trait ExceptionTrait
{

    /**
     * Description: The following method is used to throw the respective validation exception
     *
     * @author Shuja Ahmed - I2L
     *
     * @param null   $validator
     * @param string $message
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     * @throws \Illuminate\Validation\ValidationException
     */
    private function raiseValidationException($validator = null, $message = 'input_validation_error')
    {
        if ( ! $validator) {
            $this->raiseHttpResponseException($message);
        }

        $response = new Response();
        throw new ValidationException(
            $validator,
            $response->error($message, $validator->errors()->getMessages())
        );
    }

    /**
     * Description: The following method is used to throw the respective response exception
     *
     * @author Youssef - I2L
     *
     * @param null $message
     * @param null $data
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    private function raiseHttpResponseException($message = null, $data = null)
    {
        $response = new Response();

        throw new HttpResponseException($response->failed($message, $data));
    }


    /**
     * Description: The following method is used to throw the respective for Invalid JSON Request
     *
     * @author Youssef - I2L
     *
     * @param null $message
     * @param null $data
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    private function raiseInvalidJsonException($message = null, $data = null)
    {
        $response = new Response();

        throw new HttpResponseException($response->error($message, $data));
    }


    /**
     * Description: The following method is used to throw the respective for Invalid device Access
     *
     * @author Youssef - I2L
     *
     * @param null $message
     * @param null $data
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    private function raiseAuthorizationException($message = null, $data = null)
    {
        $response = new Response();

        throw new HttpResponseException($response->unauthorized($message, $data));
    }
}