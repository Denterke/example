<?php
/**
 * Created by PhpStorm.
 * User: denter
 * Date: 05.04.18
 * Time: 21:34
 */

namespace App\AnotherClasses;

use Illuminate\Http\Exceptions\HttpResponseException;

class ResponseHandler
{
    const DATA_SUCCESS_MSG = "Данные успешно получены";

    public static function getJsonResponse($status, $message, $object = null) {
        return response()
            ->json(['status' => $status, 'message' => $message, 'object' => $object]);
    }

    public static function getValidationResponse($status, $object) {
        throw new HttpResponseException(response()->json(['status' => $status, 'message' => 'Проверьте правильность введенных данных.', 'object' => $object]));
    }

    public static function getAuthJsonResponse($status, $message, $token) {
        return response()
            ->json(['status' => $status, 'message' => $message, 'token' => $token], 200)->cookie('Authorization', $token);
    }

    public static function getDataSuccessJsonResponse($object = null) {
        return response()
            ->json(['status' => 200, 'message' => self::DATA_SUCCESS_MSG, 'object' => $object], 200);
    }
}
