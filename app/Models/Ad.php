<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use HasFactory;

    /**
     * Obtém todos os dados relacionados ao anúncio e se necessário aplica os devidos filtros
     *
     * @param [type] $query
     * @param [type] $request
     * @return void
     */
    public function scopeSearch($query, $userId = null, $request = null) {

        $query->from("ads as a")
        ->join("brands as b", "b.id", "a.brand_id")
        ->join("vehicle_types as v", "v.id", "a.vehicle_type_id")
        ->select("a.*", "v.name as vehicle_type_name", "b.name as brand_name");

        if ($request->search) {

            $query->where(function ($query) use ($request){

                $query->whereRaw  ("LOWER(a.name) LIKE '%$request->search%'");
                $query->orWhereRaw("LOWER(b.name) LIKE '%$request->search%'");
                $query->orWhereRaw("LOWER(v.name) LIKE '%$request->search%'");
                $query->orWhereRaw("LOWER(a.color) LIKE '%$request->search%'");

            });

        }

        if ($userId) {
            $query->where("user_id", $userId);
        }


    }

}
