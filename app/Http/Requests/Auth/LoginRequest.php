<?php

namespace App\Http\Requests\Auth;

use App\AnotherClasses\ResponseHandler;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'             => 'required|email|exists:users',
            'password'          => 'required|string|min:5|max:30',
        ];
    }

    public function messages ()
    {
        return [
            'email.required' => 'Укажите E-mail',
            'email.email'    => 'Неверный формат E-mail',
            'email.exists'   => 'Указанный E-mail не зарегистрирован',

            'password.required'     => 'Укажите Пароль',
            'password.string'       => 'Неверный формат Пароль',
            'password.min'          => 'Длина Пароля должна быть больше :min символов',
            'password.max'          => 'Длина Пароля должна быть меньше :max символов',

        ];
    }

    protected function failedValidation(Validator $validator) {
        ResponseHandler::getValidationResponse(400, $validator->errors());
    }
}
