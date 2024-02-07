<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WeatherRequest extends FormRequest
{
    public function rules()
    {
        return [
            'cityName' => 'required|string|max:255',
            'source' => 'required|string'
        ];
    }
}