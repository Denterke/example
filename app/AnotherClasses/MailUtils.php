<?php

namespace App\AnotherClasses;

use Illuminate\Support\Facades\Mail;

class MailUtils {

    const SENDER    = "no-reply@visit-primorye.ru";

    public static function sendMail($subject, $view, $surname, $name, $patronymic, $email, $verification_code) {
        Mail::send(
            $view,
            [
                'surname'           => $surname,
                'name'              => $name,
                'patronymic'        => $patronymic,
                'verification_code' => $verification_code
            ],
            function($message) use ($name, $email, $subject) {
                $message
                    ->to($email, $name)
                    ->from(self::SENDER)
                    ->subject($subject);
            }
        );
    }
}
