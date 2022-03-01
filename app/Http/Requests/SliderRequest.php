<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SliderRequest extends FormRequest
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
            'small_text_1' => 'required|min:3',
            'small_text_2' => 'required|min:3',
            'big_text' => 'required|min:3',
            'button_text' => 'required|min:3',
        ];
    }

    public function attributes()
    {
        return [
            'big_text' => 'Заголовок',
            'small_text_1' => 'Червоний текст',
            'small_text_2' => 'Чорний текст',
            'button_text' => 'Текст на кнопці',
        ];
    }
}
