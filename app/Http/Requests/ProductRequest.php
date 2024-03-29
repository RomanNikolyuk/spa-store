<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'title' => 'required|min:3',
            'small_desc' => 'required|min:3',
            'category_id' => 'required|integer',
            'big_desc' => 'required|min:3',
            'price' => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Заголовок товару обов\'язковий',
            'small_desc.required' => 'Короткий опис обов\'язковий',
            'category_id.required' => 'Щось не так з категорією ❔',
            'big_desc.required' => 'Розширений опис обов\'язковий',
            'price.required' => 'Вкажіть ціну',
            'min' => 'Всі текстові поля мають містити щонайменше <strong>3 символи</strong>'
        ];
    }
}
