<?php

namespace App\Http\Requests;

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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'mobile' => 'required|unique:users|numeric|digits:10'
        ];
    }

    public function messages()
    {
        return [
            'mobile.required' => 'Mobile no is required!',
            'mobile.numeric' => 'Mobile no should have numerical value!',
            'mobile.min' => 'Mobile no should have minimum 10 characters!',
        ];
    }
}
