<?php

namespace App\Http\Requests\Auth;

use App\AnotherClasses\ResponseHandler;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'surname'           => 'required|string|min:3|max:100',
            'name'              => 'required|string|min:3|max:100',
            'patronymic'        => 'required|string|min:3|max:100',
            'city'              => 'string|max:100',
            'phone'             => 'nullable|string|min:10|max:20',
            'company'           => 'nullable|string|max:250',
            'company_inn'       => 'nullable|string',
            'email'             => 'required|email|unique:users',
            'password'          => 'required|string|min:5|max:30|confirmed',
            'policy_accepted'   => 'required',
        ];
    }

    public function messages ()
    {
        return [
            'surname.required'  => 'Не указана Фамилия',
            'surname.string'    => 'Неверный формат Фамилии',
            'surname.min'       => 'Фамилия должна быть длиннее :min символов',
            'surname.max'       => 'Фамилия должна быть короче :max символов',

            'name.required'  => 'Укажите Имя',
            'name.string'    => 'Неверный формат Имени',
            'name.min'       => 'Имя должно быть длиннее :min символов',
            'name.max'       => 'Имя должно быть короче :max символов',

            'patronymic.required'  => 'Укажите Отчество',
            'patronymic.string'    => 'Неверный формат Отчества',
            'patronymic.min'       => 'Отчество должно быть длиннее :min символов',
            'patronymic.max'       => 'Отчество должно быть короче :max символов',

            'city.string'      => 'Неверный формат Города',
            'city.max'          => 'Название Города должно быть короче :max символов',

            'phone.string'      => 'Неверный формат Телефона',
            'phone.min'         => 'Телефон должен быть длиннее :min символов',
            'phone.max'         => 'Телефон должна быть короче :max символов',

            'company.string'    => 'Неверный формат поля "Ваша компания"',
            'company.max'       => 'Название Компании должно быть короче :max символов',

            'company_inn.string'   => 'Неверный формат ИНН компании',

            'email.required'    => 'Укажите E-mail',
            'email.email'       => 'Неверный формат E-mail',
            'email.unique'      => 'Указанный E-mail уже зарегистрирован',

            'password.required'     => 'Укажите Пароль',
            'password.string'       => 'Неверный формат Пароля',
            'password.min'          => 'Длина Пароля должна быть больше :min символов',
            'password.max'          => 'Длина Пароля должна быть меньше :max символов',
            'password.confirmed'    => 'Пароли не совпадают',

            'policy_accepted.required'     => 'Вы должны принять политику конфиденциальности',
        ];
    }

    protected function failedValidation(Validator $validator) {
        ResponseHandler::getValidationResponse(400, $validator->errors());
    }
}
