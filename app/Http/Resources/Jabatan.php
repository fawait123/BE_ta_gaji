<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Jabatan extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'nama'=>$this->nama,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
            'deleted_at'=>$this->deleted_at,
            'tipe'=>$this->tipe,
            // 'potongans'=>collect($this->potongans)->unique('jabatan_id','komponen_id'),
            // 'tunjangans'=>collect($this->tunjangans)->unique('jabatan_id','komponen_id'),
            'potongans'=>$this->uniqCustom($this->potongans),
            'tunjangans'=>$this->uniqCustom($this->tunjangans),
        ];
    }

    public function uniqCustom($data)
    {
        $filterData = collect([]);

        foreach($data as $row){
            $cari = $filterData->where('jabatan_id',$row->jabatan_id)->where('komponen_id',$row->komponen_id)->all();
            if(count($cari) == 0){
                $filterData->push([
                    "id"=> $row->id,
                    "komponen_id"=> $row->komponen_id,
                    "jabatan_id"=> $row->jabatan_id,
                    "jumlah"=> $row->jumlah,
                    'komponen'=>$row->komponen,
                    "created_at"=> $row->created_at,
                    "updated_at"=> $row->updated_at,
                    "deleted_at"=> $row->deleted_at,
                ]);
            }
        }

        return $filterData;

    }
}
