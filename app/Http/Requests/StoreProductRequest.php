<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name' => 'required|unique:products|max:30',
            'description' => 'required',
            'in_stock' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Поле Имя товара должно быть заполнено',
            'name.unique' => 'Имя товара должно быть уникально',
            'description.required' => 'Заполните описание товара',
            'in_stock.required' => 'Поле количесов товара должно быть заполнено'
        ];
    }
}
