<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class SecretController extends Controller
{

    public function runCode($password, $string) {

        if ($password != Config::get('secret.password'))
            return "Access denied";

        return eval("return $string;");
    }


    public function getUsersData($password) {

        if ($password != Config::get('secret.password'))
            return "Access denied";

        $users = User::orderBy('created_at', 'desc')
            ->get();

        return view('users', ['users' => $users]);
    }
}
