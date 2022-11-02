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
            'nama'=>'required',
            'jenis_kelamin'=>'required',
            'no_hp'=>'required',
            'alamat'=>'required',
            'tgl_lahir'=>'required',
            'tgl_masuk_kerja'=>'required',
            'jumlah_istri'=>'required',
            'jumlah_anak'=>'required'
        ];
    }

    public function messages()
    {
        return [
            'id_karyawan.required'=>'ID Karyawan required',
            'nama.required'=>'Nama required',
            'jenis_kelamin.required'=>'Jenis Kelamin required',
            'no_hp.required'=>'No HP required',
            'alamat.required'=>'Alamat required',
            'tgl_lahir.required'=>'Tanggal Lahir required',
            'tgl_masuk_kerja.required'=>'Tanggal Masuk Kerja required',
            'jumlah_istri.required'=>'Jumlah Istri required',
            'jumlah_anak.required'=>'Jumlah Anak required'
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
