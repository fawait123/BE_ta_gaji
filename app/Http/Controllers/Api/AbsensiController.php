<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Pagination;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\AbsensiRequest;
use App\Models\Absensi;
use App\Models\Karyawan;
use Exception;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{
            $meta = Pagination::defaultMetaInput($request->only(['page','perPage','order','dir','search']));
            $query = Absensi::query();
            $query->where(function($q) use($meta){
                $q->orWhere('status_kehadiran', 'like', $meta['search'] . '%');
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
        }catch(Exception $error){
            return Response::send(500,$error->getMessage());

        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AbsensiRequest $request)
    {
        try{
            $storeData = Absensi::create($request->all());
            $data = [
                'message'=>'Data Created Success',
                'data'=>$storeData
            ];
            return Response::send(200,$data);
        }catch(Exception $error){
            return Response::send(500,$error->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $check = Absensi::where('id',$request->id)->first();
        if($check){
            $updateData = Absensi::where('id',$request->id)->update($request->all());
            $data = [
                'message'=>'Data Updated Success',
                'data'=>$updateData
            ];
            return Response::send(200,$data);
        }
        $data = [
            "message"=>'Data Not found',
            "data"=>[]
        ];
        return Response::send(200,$data);
    } catch (Exception $error) {
            return Response::send(500,$error->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
       try {
        $check = Absensi::find($request->id);
    	if($check){
    	   $check->delete();
    	   $data = [
    	       "message"=>"Data Deleted Success",
    	       "data"=>$check
           ];
           return Response::send(200,$data);
    	}
    	$data = [
    	   "message"=>"Data Not Found",
    	   "data"=>[]
    	];
        return Response::send(200,$data);
    } catch (Exception $error) {
           return Response::send(500,$error->getMessage());
       }
    }
}
