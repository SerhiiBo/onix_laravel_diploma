<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
            'name' => 'required|unique:categories|max:50',
            'description' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Поле Имя категории должно быть заполнено',
            'name.unique' => 'Такая категория уже существует',
        ];
    }
}
