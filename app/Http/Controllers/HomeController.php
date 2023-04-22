<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Brand;
use App\Models\VehicleType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller {

    /**
     * Redireciona à index de exibição dos anúncios
     */
    public function index(Request $request) {

        $paginate = $request->paginate ?? 50;
        $ads = Ad::searchGeneral($request)->paginate($paginate);
        $types = VehicleType::all();
        $brands = Brand::all();

        $search = count($request->all()) ? (object) $request->all() : (object) [
            "vehicle_types"     => 1,
            "brand_id"          => "",
            "vehicle_type_id"   => 1,
            "color"             => "",
            "price_range_begin" => "",
            "price_range_end"   => "",
            "begin_avaliable_date" => "",
            "end_avaliable_date" => ""
        ];

        $search->vehicle_type_name = VehicleType::find($search->vehicle_type_id)->name;

        $data = [
            "ads" => $ads,
            "search" => $search,
            "paginate" => $paginate,
            "types" => $types,
            "brands" => $brands,
        ];

        return view("pages.home", $data);
    }
}
