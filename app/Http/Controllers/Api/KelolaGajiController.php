<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Potongan;
use App\Models\Tunjangan;
use Exception;
use Illuminate\Http\Request;

class KelolaGajiController extends Controller
{
    public function postMulti(Request $request)
    {
        try {
        $data = $request->all();
        $result = [];
        // penambahan
        foreach ($data['penambahan'] as $key) {
            if($key['id'] == null){
                Tunjangan::create($key);
                unset($key['id']);
                array_push($key);
            }else{
                $check = Tunjangan::find($key['id']);
                $check->komponen_id = $key['komponen_id'];
                $check->jabatan_id = $key['jabatan_id'];
                $check->jumlah = $key['jumlah'];
                $check->save();
                array_push($result,[
                    'komponen_id'=>$check->komponen_id,
                    'jabatan_id'=>$check->jabatan_id,
                    'jumlah'=>$check->jumlah,
                ]);
            }
        }
        // pengurangan
        foreach ($data['pengurangan'] as $key) {
            if($key['id'] == null){
                Potongan::create($key);
                unset($key['id']);
                array_push($key);
            }else{
                $check = Potongan::find($key['id']);
                $check->komponen_id = $key['komponen_id'];
                $check->jabatan_id = $key['jabatan_id'];
                $check->jumlah = $key['jumlah'];
                $check->save();
                array_push($result,[
                    'komponen_id'=>$check->komponen_id,
                    'jabatan_id'=>$check->jabatan_id,
                    'jumlah'=>$check->jumlah,
                ]);
            }
        }
        $data = [
            'message'=>'Data Created Success',
            'data'=>$result
        ];
        return Response::send(200,$data);
        } catch (Exception $error) {
            Response::send(500,$error->getMessage());
        }
    }
}
