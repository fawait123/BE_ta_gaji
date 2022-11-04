<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class KaryawanRequest extends FormRequest
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
            'id_karyawan'=>'required',
            'jabatan_id'=>'required',
            'nama'=>'required',
            'jenis_kelamin'=>'required',
            'no_hp'=>'required',
            'alamat'=>'required',
            'tgl_lahir'=>'required',
            'tgl_masuk_kerja'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'jabatan_id.required'=>'Jabatan required',
            'nama.required'=>'Nama required',
            'jenis_kelamin.required'=>'Jenis Kelamin required',
            'no_hp.required'=>'No HP required',
            'alamat.required'=>'Alamat required',
            'tgl_lahir.required'=>'Tanggal Lahir required',
            'tgl_masuk_kerja.required'=>'Tanggal Masuk Kerja required',
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
