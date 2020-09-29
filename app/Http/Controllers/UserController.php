<?php

namespace App\Http\Controllers;

use App\AnotherClasses\RequestUtils;
use App\AnotherClasses\ResponseHandler;
use App\AnotherClasses\SendPlusHandler;
use App\Http\Requests\UserMessageRequest;
use App\User;
use App\UsersBroadcast;
use App\UsersMessage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all()
            ->groupBy('role');

        return ResponseHandler::getDataSuccessJsonResponse($users);
    }

    public function show(Request $request, $id)
    {
        $user = User::find($id)->load('broadcasts');

        return ResponseHandler::getDataSuccessJsonResponse($user);
    }

    public function subscribeToBroadcast(Request $request, $id, $broadcast_id, $book_id)
    {
        $user = User::find($id);

        $checkIfExists = UsersBroadcast::where('user_id', $user->id)
            ->where('broadcast_id', $broadcast_id)
            ->first();

        if ($checkIfExists !== null)
            return ResponseHandler::getJsonResponse(200, "Вы уже подписаны на данную трансляцию");

        UsersBroadcast::create([
            'user_id' => $user->id,
            'broadcast_id'  => $broadcast_id
        ]);

        $mailer = new SendPlusHandler();
        $user_name = $user->surname .' '. $user->name .' '. $user->patronymic;

        $mailer->addToMailList($book_id, $user->email, $user->phone, $user_name);

        return ResponseHandler::getJsonResponse(200, "Вы подписались на данную трансляцию");
    }

    public function unsubscribeFromBroadcast(Request $request, $id, $broadcast_id, $book_id)
    {
        $user = User::find($id);

        UsersBroadcast::where('user_id', $user->id)
            ->where('broadcast_id', $broadcast_id)
            ->delete();

        $mailer = new SendPlusHandler();

        $mailer->removeFromMailList($book_id, $user->email);

        return ResponseHandler::getJsonResponse(200, "Вы отписались от трансляции");
    }

    public function sendMessage(UserMessageRequest $request, $id) {

        $user = User::find($id);

        $last_message = UsersMessage::where('user_id', $id)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($last_message) {
            $diff = Carbon::now()->diffInMinutes($last_message->created_at);

            if ($diff < 5)
                return ResponseHandler::getJsonResponse(400, "Сообщения можно отправлять не чаще раза в течение пяти минут");
        }

        $message = UsersMessage::create([
            'user_id'       => $id,
            'message'       => $request->message,
            'broadcast_id'  => $request->broadcast_id
        ]);

        $data = [
            'broadcast_id' => $request->broadcast_id,
            'message'      => $request->message,
            'full_name'    => $user->surname." ".$user->name." ".$user->patronymic,
            'company'      => $user->company,
            'city'         => $user->city,
            'secret'       => UsersMessage::SECRET

        ];

        if (!RequestUtils::postQuery('http://admin.visit-primorye.com/api/message', $data)) {
            UsersMessage::where('id', $message->id)
                ->delete();

            return ResponseHandler::getJsonResponse(400, 'Произошла ошибка, попробуйте еще раз');
        }

        return ResponseHandler::getJsonResponse(200, 'Ваше сообщение отправлено');

    }

    public function getStatistic() {
        $all_users      = User::count();
        $verified_users = User::where('is_verified', 1)
                            ->count();

        $eef_users      = User::where('eef_subscription', 1)
            ->count();

        $ptf_users      = User::where('ptf_subscription', 1)
            ->count();

        return
            "Всего пользователей: $all_users</br>Из них подтвердило регистрацию: $verified_users </br></br> Из них подписалось на рассылку ВЭФ: $eef_users</br>Из них подписалось на сессии форума: $ptf_users";
    }
}
