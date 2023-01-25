<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Potongan;
use App\Models\Tunjangan;
use App\Models\Penggajian;
use Exception;
use Illuminate\Http\Request;
use App\Helpers\Pagination;

class KelolaGajiController extends Controller
{
    public function postMulti(Request $request)
    {
        try {
        $data = $request->all();
        $result = [];
        Tunjangan::where('jabatan_id',$request->jabatan_id)->delete();
        // penambahan
        foreach ($data['penambahan'] as $key) {
            // if($key['id'] == null){
                Tunjangan::create([
                    'komponen_id'=>$key['komponen_id'],
                    'jabatan_id'=>$request['jabatan_id'],
                    'jumlah'=>$key['jumlah'],
                ]);
            //     unset($key['id']);
            //     array_push($key);
            // }else{
            //     $check = Tunjangan::where('id',$key['id'])->first();
            //     if($check){
            //         Tunjangan::where('id',$key['id'])->update([
            //             "komponen_id"=>$key['komponen_id'],
            //             "jabatan_id"=>$request['jabatan_id'],
            //             "jumlah"=>$key['jumlah'],
            //         ]);
            //         array_push($result,[
            //             'komponen_id'=>$check['komponen_id'],
            //             'jabatan_id'=>$request['jabatan_id'],
            //             'jumlah'=>$check['jumlah'],
            //         ]);
            //     }
            // }
        }
        Potongan::where('jabatan_id',$request->jabatan_id)->delete();
        // pengurangan
        foreach ($data['pengurangan'] as $key) {
            // if($key['id'] == null){
                Potongan::create([
                    'komponen_id'=>$key['komponen_id'],
                    'jabatan_id'=>$request['jabatan_id'],
                    'jumlah'=>$key['jumlah'],
                ]);
                // unset($key['id']);
                // array_push($key);
            // }else{
            //     $check = Potongan::where('id',$key['id'])->first();
            //     if($check){
            //         Potongan::where('id',$key['id'])->update([
            //             "komponen_id"=>$key['komponen_id'],
            //             "jabatan_id"=>$request['jabatan_id'],
            //             "jumlah"=>$key['jumlah'],
            //         ]);
            //         array_push($result,[
            //             'komponen_id'=>$check['komponen_id'],
            //             'jabatan_id'=>$request['jabatan_id'],
            //             'jumlah'=>$check['jumlah'],
            //         ]);
            //     }
            // }
        }
        $dataResult = [
            'message'=>'Data Created Success',
            'data'=>$data
        ];
        return Response::send(200,$dataResult);
        } catch (Exception $error) {
            Response::send(500,$error->getMessage());
        }
    }

    public function index(Request $request){
        try {
            $meta = Pagination::defaultMetaInput($request->only(['page','perPage','order','dir','search']));
            $query = Penggajian::query();
            $query = $query->with(['karyawan.jabatan']);
            if($request->filled('start_date') && $request->filled('end_date')){
                $query = $query->whereBetween('tgl_penggajian', [$request->start_date, $request->end_date]);
            }
            $query->where(function($q) use($meta){
                $q->orWhereHas('karyawan',function($qr)use($meta){
                    $qr->where('nama', 'like', '%'.$meta['search'] . '%');
                });
            });
            $total = $query->count();
            $meta = Pagination::additionalMeta($meta, $total);
            if ($meta['perPage'] != '-1') {
                $query->offset($meta['offset'])->limit($meta['perPage']);
            }
            $results = $query->get();
            $data = [
                'message'  => 'List Data Karyawan',
                'results'  => $results,
                'meta'     =>  $meta
            ];
            return Response::send(200,$data);
        } catch (Exception $error) {
            return Response::send(500, $error->getMessage());
        }
    }
}
