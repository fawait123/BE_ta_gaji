<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Jabatan;
use App\Models\Komponen;
use App\Models\User;
use App\Helpers\Response;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $karyawan = Karyawan::count();
        $jabatan = Jabatan::count();
        $komponen = Komponen::count();
        $pengguna = User::count();

        $data = [
            "karyawan"=>$karyawan,
                "pengguna"=>$pengguna,
                "jabatan"=>$jabatan,
                "komponen"=>$komponen
        ];

        $data = [
            'message'=>'success',
            'data'=>$data
        ];
        return Response::send(200,$data);
    }
}
