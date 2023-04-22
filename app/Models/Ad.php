<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use HasFactory;

    /**
     * Obtém raça de pet
     *
     * @return void
    */
    public function rent(){
        return $this->belongsTo(Rent::class);
    }

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
            $query->where("a.user_id", $userId);
        }

    }

    /**
     * Obtém todos os dados relacionados ao anúncio e se necessário aplica os devidos filtros
     *
     * @param [type] $query
     * @param [type] $request
     * @return void
     */
    public function scopeSearchGeneral($query, $request = null) {

        $query->from("ads as a")
        ->join("brands as b", "b.id", "a.brand_id")
        ->join("vehicle_types as v", "v.id", "a.vehicle_type_id")
        ->select("a.*", "v.name as vehicle_type_name", "b.name as brand_name");

        if (count($request->all())) {

            if($request->vehicle_type_id) $query->where("a.vehicle_type_id", $request->vehicle_type_id);
            if($request->brand_id) $query->where("a.brand_id", $request->brand_id);
            if($request->color) $query->whereRaw("LOWER(a.color) LIKE '%".$request->color."%'");
            if($request->price_range_begin) $query->where("a.price_per_day", ">", unMaskPrice($request->price_range_begin));
            if($request->price_range_end) $query->where("a.price_per_day", "<", unMaskPrice($request->price_range_end));

            if($request->begin_avaliable_date) {
                $beginDate = Carbon::createFromFormat('d/m/Y', $request->begin_avaliable_date)->toDateString();
                $query->where("a.begin_avaliable_date", ">", $beginDate);
            }

            if($request->end_avaliable_date) {
                $endDate = Carbon::createFromFormat('d/m/Y', $request->end_avaliable_date)->toDateString();
                $query->where("a.end_avaliable_date", "<", $endDate);
            }

        }

    }

    /**
     * Obtém os anúncios alugador por um usuário
     *
     * @param [type] $query
     * @param [type] $userId
     * @param [type] $request
     * @return void
     */
    public function scopeGetByRent($query, $userId, $request) {

        $query->from("ads as a")
        ->join("brands as b", "b.id", "a.brand_id")
        ->join("vehicle_types as v", "v.id", "a.vehicle_type_id")
        ->join("rents as r", "r.ad_id", "a.id")
        ->select("a.*", "v.name as vehicle_type_name", "b.name as brand_name");

        if ($request->search) {

            $query->where(function ($query) use ($request){

                $query->whereRaw  ("LOWER(a.name) LIKE '%$request->search%'");
                $query->orWhereRaw("LOWER(b.name) LIKE '%$request->search%'");
                $query->orWhereRaw("LOWER(v.name) LIKE '%$request->search%'");
                $query->orWhereRaw("LOWER(a.color) LIKE '%$request->search%'");

            });

        }

        $query->where("r.hirer_id", $userId);

    }

}
