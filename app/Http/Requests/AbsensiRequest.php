<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AbsensiRequest extends FormRequest
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
            'tgl_absen'=>'required',
            'jam_masuk'=>'required',
            'jam_pulang'=>'required',
            'status_kehadiran'=>'required'
        ];
    }

    public function messages()
    {
        return [
            'tgl_absen.required'=>'Tanggal Absen required',
            'jam_masuk.required'=>'Jam Masuk required',
            'jam_pulang.required'=>'Jam Pulangrequired',
            'status_kehadiran.required'=>'Status Kehadiran required'
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
