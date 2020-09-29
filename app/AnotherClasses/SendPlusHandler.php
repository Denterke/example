<?php

/**
 * Created by PhpStorm.
 * User: denter
 * Date: 05.04.18
 * Time: 21:34
 */

namespace App\AnotherClasses;

use Illuminate\Support\Facades\Config;
use Sendpulse\RestApi\ApiClient;
use Sendpulse\RestApi\Storage\FileStorage;

class SendPlusHandler {

    private $SPApiClient;
    public const EEF_BOOK_ID = 793500;
    public const PTF_BOOK_ID = 813825;

    public function __construct()
    {
        $this->SPApiClient = new ApiClient(Config::get('sendplus.sp_user_id'), Config::get('sendplus.sp_secret'));
    }

    public function boot() {
        return  $this->SPApiClient->listAddressBooks();
    }


    public function addToMailList($book_id, $email, $phone = null, $name = null) {
        return $this->SPApiClient->addEmails(
            $book_id,
            [
                [
                    'email' => $email,
                    'variables' => [
                        'phone' => $phone,
                        'ФИО'  => $name
                    ]
                ]
            ]
        );

    }

    public function removeFromMailList($book_id, $email) {
        return $this->SPApiClient->removeEmails(
            $book_id,
            [
                $email,
            ]
        );
    }

    public function sendMail() {
        $email = array(
            'html' => '<p>Hello!</p>',
            'text' => 'Hello!',
            'subject' => 'Mail subject',
            'from' => array(
                'name' => 'John',
                'email' => 'sender@example.com',
            ),
            'to' => array(
                array(
                    'name' => 'Subscriber Name',
                    'email' => 'adgfq121519@gmail.com',
                ),
            )
        );
        var_dump($this->SPApiClient->smtpSendMail($email));
    }

}
