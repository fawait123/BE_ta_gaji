<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PotonganRequest extends FormRequest
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
            'komponen_id'=>'required',
            'jabatan_id'=>'required',
            'jumlah'=>'required'
        ];
    }

    public function messages()
    {
        return [
            'komponen_id.required'=>'Komponen required',
            'jabatan_id.required'=>'Jabatan required',
            'jumlah.required'=>'Jumlah required'
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
