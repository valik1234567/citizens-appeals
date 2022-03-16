<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppealRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'category_id' => 'required|integer',
            'title' => 'required|string',
            'description' => 'required|string',
        ];
    }
}
