<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
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
        $rules =  [
            'nama'=>'required',
            'email'=>'required|email',
            'password'=>'required',
            'username'=>'required',
            'role'=>'required'
        ];

        if (in_array($this->method(), ['PATCH', 'PUT'])) {
            unset($rules['password']);
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'nama.required'=>'Nama required',
            'email.required'=>'Email required',
            'email.email'=>'Email tidak valid',
            'password.required'=>'Password required',
            'username.required'=>'Username required',
            'role.required'=>'Role required'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()

        ],400));

    }
}
