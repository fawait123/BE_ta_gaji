<?php

namespace Database\Seeders;

use App\Models\Karyawan;
use Illuminate\Database\Seeder;

class KaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Karyawan::create([
        "id_karyawan"=>"16387132",
        "id_jabatan"=>"1232332",
        "nama"=>"Achmad Fawait",
        "jenis_kelamin"=>"laki-laki",
        "no_hp"=>"085728282",
        "alamat"=>"Banjar Timur Gapura Sumenep",
        "tgl_lahir"=>"1998-01-14",
        "tgl_masuk_kerja"=>"2022-11-01",
        "jumlah_istri"=>1,
        "jumlah_anak"=>0
        ]);
    }
}
