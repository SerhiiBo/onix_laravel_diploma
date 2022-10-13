<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionRequest extends FormRequest
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
            'text' => 'required|min:5|max:200',
        ];
    }

    public function messages()
    {
        return [
            'text.required' => 'Поле Text должно быть заполнено',
            'text.min' => 'Минимальная длинна поля Text - 20',
            'text.max' => 'Максимальаня длинна поля Text - 200',
        ];
    }
}
