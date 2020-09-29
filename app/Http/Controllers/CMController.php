<?php

namespace App\Http\Controllers;

use App\AnotherClasses\RequestUtils;
use App\User;
use Illuminate\Http\Request;

class CMController extends Controller
{
    public function postCM(Request $request) {

        $route =  "https://api.clickmeeting.com/v1/conferences/". $request->link ."/room/autologin_hash";

        $data = [
            'email' => $request->email,
            'nickname'  => $request->nickname,
            'role'  => $request->role
        ];

        return RequestUtils::APIpostQuery($route, $data);

    }

    public function getCM($link) {

        $route =  "https://api.clickmeeting.com/v1/conferences/". $link;

        return RequestUtils::APIgetQuery($route);

    }

    public function usersData() {
        $users = User::select('surname', 'name', 'patronymic', 'email')
            ->get();

        return $users;
    }
}
