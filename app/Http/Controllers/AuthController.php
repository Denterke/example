<?php

namespace App\Http\Controllers;

use App\AnotherClasses\MailUtils;
use App\AnotherClasses\RequestUtils;
use App\AnotherClasses\ResponseHandler;
use App\AnotherClasses\SendPlusHandler;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\User;
use App\UserVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use function Symfony\Component\VarDumper\Dumper\esc;

class AuthController extends Controller
{

    public function register(RegisterRequest $request)
    {
        $data = [
            'secret'    => Config::get('captcha.password'),
            'response'  => $request->token
        ];

        if (!RequestUtils::postQuery('https://www.google.com/recaptcha/api/siteverify', $data))
            return ResponseHandler::getJsonResponse(400, 'Неверно введена Captcha');

        $user = User::create([
            'surname'           => $request->surname,
            'name'              => $request->name,
            'patronymic'        => $request->patronymic,
            'city'              => $request->city,
            'phone'             => $request->phone,
            'company'           => $request->company,
            'company_inn'       => $request->company_inn,
            'email'             => $request->email,
            'password'          => bcrypt($request->password),
            'eef_subscription'  => $request->has('eef_subscription'),
            'ptf_subscription'  => $request->has('ptf_subscription'),
            'is_verified'       => true
        ]);

        $verification_code = Str::random(40); //Generate verification code

        UserVerification::create([
            'user_id'   => $user->id,
            'token'     => $verification_code
        ]);

        MailUtils::sendMail(
            "Подтверждение регистрации",
            "email.verifyEmail",
            $user->surname, $user->name,
            $user->patronymic,
            $user->email,
            $verification_code
        );

        $mailer = new SendPlusHandler();
        $user_name = $user->surname .' '. $user->name .' '. $user->patronymic;

        if ($request->eef_subscription)
            $mailer->addToMailList(SendPlusHandler::EEF_BOOK_ID, $user->email, $user->phone, $user_name);

        if ($request->ptf_subscription)
            $mailer->addToMailList(SendPlusHandler::PTF_BOOK_ID, $user->email, $user->phone, $user_name);

        return ResponseHandler::getJsonResponse(200, 'Спасибо за регистрацию. Пожалуйста, проверьте почту для подтверждения регистрации.');
    }

    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)
            ->first();

        if ($user->is_verified == 0)
            return ResponseHandler::getJsonResponse(400, 'Пожалуйста, проверьте почту и подтвердите регистрацию');

        $credentials = $request->only('email', 'password');
        $credentials['is_verified'] = 1;

        if ($token = $this->guard()->attempt($credentials)) {
            return ResponseHandler::getAuthJsonResponse(200, 'Вы успешно авторизованы', $token);
        }

        return ResponseHandler::getJsonResponse(400, 'Ошибка авторизации, проверьте правильность введенных данных');
    }

    public function logout()
    {
        $this->guard()->logout();

        return ResponseHandler::getJsonResponse(200, 'Вы вышли из аккаунта');

    }

    public function user(Request $request)
    {
        $user = User::find(Auth::user()->id)->load('broadcasts');
        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }

    public function refresh()
    {
        try {
            if ($token = $this->guard()->refresh()) {
                return ResponseHandler::getAuthJsonResponse(200, 'Токен успешно обновлен', $token);
            }
        }
        catch (\Exception $e) {
            return ResponseHandler::getJsonResponse(400, 'Токен не был обновлен');
        }

        return ResponseHandler::getJsonResponse(400, 'Токен не был обновлен');
    }

    public function verifyUser($verification_code) {
        $message = "Не удается подтвердить регистрацию.";

        $check = UserVerification::where('token', $verification_code)
            ->first();

        if (!is_null($check)) {
            $user = User::find($check->user_id);

            if ($user->is_verified == 1) {
                $message = "Данный email уже подтвержден.";
            }
            else {
                $user->update(['is_verified' => 1]);

                UserVerification::where('token', $verification_code)
                    ->delete();

                $message = "Ваш email успешно подтвержден. Закройте, пожалуйста, эту страницу.";
            }
        }

        return response()
            ->view('eef/verify', compact('message'), 200)
            ->header("Refresh", "0.4; url=http://visit-primorye.ru/#register");
    }

    public function resetPassword($email) {
        $user = User::where('email', $email)->first();

        if (!$user)
            return ResponseHandler::getJsonResponse(400, 'Указанный email еще не зарегистрирован в системе.');

        $verification_code = Str::random(40);

        UserVerification::create([
            'user_id'   => $user->id,
            'token'     => $verification_code
        ]);

        MailUtils::sendMail("Смена пароля",
            "email.verifyPassword",
            $user->surname,
            $user->name,
            $user->patronymic,
            $user->email,
            $verification_code
        );

        return ResponseHandler::getJsonResponse(200, 'Новый пароль сгенерирован. Пожалуйста, проверьте почту для подтверждения смены пароля.');

    }

    public function verifyPassword($verification_code) {
        $message = "Не удается обновить пароль.";

        $check = UserVerification::where('token', $verification_code)
            ->first();

        if (!is_null($check)) {
            $user = User::find($check->user_id);

            $user->update(['password' => bcrypt(substr($verification_code, 0, 5))]);

            UserVerification::where('token', $verification_code)
                ->delete();

            $message = "Ваш пароль успешно обновлен. Закройте, пожалуйста, эту страницу.";

        }

        return response()
            ->view('eef/verify', compact('message'), 200)
            ->header("Refresh", "0.4; url=http://visit-primorye.ru/#register");
    }

    private function guard()
    {
        return Auth::guard();
    }
}
