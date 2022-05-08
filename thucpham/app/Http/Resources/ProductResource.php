<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'=> $this->id,
            'ten'=> $this->ten,
            'mota'=> $this->mota,
            'anh'=> $this->anh,
            'donvi'=> $this->donvi,
            'soluong'=> $this->soluong,
            'dongia'=> $this->dongia,
            'idloai'=> $this->idloai,
            'idthuonghieu'=> $this->idthuonghieu
        ];
    }
}
