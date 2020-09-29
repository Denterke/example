<?php

namespace App\AnotherClasses;

use Illuminate\Support\Facades\Mail;

class RequestUtils {

    public static function postQuery($route, $data) {
        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            ]
        ];

        $context  = stream_context_create($options);
        $result = file_get_contents($route, false, $context);

        if (json_decode($result)->success == FALSE) {
            return false;
        }

        return true;
    }

    public static function APIpostQuery($route, $data) {
        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\nX-Api-Key: us50746a7bf8021cd4d1bb4c9477202eda16c2ac10\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            ]
        ];

        $context  = stream_context_create($options);
        $result = file_get_contents($route, false, $context);

        return $result;
    }

    public static function APIgetQuery($route) {
        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\nX-Api-Key: us50746a7bf8021cd4d1bb4c9477202eda16c2ac10\r\n",
                'method'  => 'GET'
            ]
        ];

        $context  = stream_context_create($options);
        $result = file_get_contents($route, false, $context);

        return $result;
    }

}
