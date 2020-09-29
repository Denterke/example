<?php

namespace App\Http\Requests;

use App\AnotherClasses\ResponseHandler;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UserMessageRequest extends FormRequest
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
            'message'           => 'required|string',
            'broadcast_id'      => 'required|numeric',
        ];
    }

    public function messages ()
    {
        return [
            'message.required' => 'Укажите значение поля "Сообщение"',
            'message.string'   => 'Неверный формат поля "Сообщение"',

            'broadcast_id.required' => 'Укажите значение поля "broadcast_id"',
            'broadcast_id.numeric'   => 'Неверный формат поля "broadcast_id"',
        ];
    }

    protected function failedValidation(Validator $validator) {
        ResponseHandler::getValidationResponse(400, $validator->errors());
    }
}
