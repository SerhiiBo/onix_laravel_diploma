<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => ['nullable', 'confirmed', Password::min(6)->mixedCase()->numbers()->uncompromised()],
            'address_city' => 'required',
            'address_street' => 'required',
            'address_house' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Поле name должно быть заполнено',
            'email.required' => 'Поле email должно быть заполнено',
            'email.email' => 'Поле должно быть адресом email',
            'email.uniqe' => 'Email должен быть уникальным',
            'password.confirmed' => 'Пароль не соответсвует',
            'address_city.required' => 'Поле город должно быть заполнено',
            'address_street.required' => 'Поле улица должно быть заполнено',
            'address_house.required' => 'Поле номер дома/квартиры должно быть заполнено',
        ];
    }
}
