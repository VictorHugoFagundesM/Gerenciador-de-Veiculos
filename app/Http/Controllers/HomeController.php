<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller {

    /**
     * Redireciona à index de exibição dos anúncios
     */
    public function index(Request $request) {

        $paginate = $request->paginate ?? 50;
        $ads = Ad::search(null, $request)->paginate($paginate);

        $data = [
            "ads" => $ads,
            "search" => $request->search,
            "paginate" => $paginate
        ];

        return view("pages.home", $data);
    }
}
