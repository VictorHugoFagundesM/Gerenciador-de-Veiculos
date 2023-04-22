<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Brand;
use App\Models\User;
use App\Models\VehicleType;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

/**
 * Controller da entidade ads
 *
 * @author Victor Hugo Fagundes Miranda <victorhugofmiranda@gmail.com>
 * @since 16/04/2023
 * @version 1.0.0
 */
class AdController extends Controller {

    /**
     * Redireciona à index de exibição dos anúncios
     */
    public function index(Request $request) {

        $paginate = $request->paginate ?? 10;

        $user = Auth::user();
        $ads = Ad::search($user->id, $request)->paginate($paginate);

        $data = [
            "ads" => $ads,
            "search" => $request->search,
            "paginate" => $paginate
        ];

        return view("pages.ads.index", $data);
    }

    /**
     * Redireciona à página de criação de anúncio
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create() {

        $types = VehicleType::all();
        $brands = Brand::all();
        $ad = new Ad();

        $data = [
            "types"  => $types,
            "brands" => $brands,
            "ad"     => $ad,
        ];

        return view("pages.ads.create-edit", $data);

    }

    /**
     * Redireciona à página de edição de anúncio
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(int $id = null) {

        $types = VehicleType::all();
        $brands = Brand::all();
        $ad = Ad::find($id);

        if ($ad) {

            $data = [
                "types"  => $types,
                "brands" => $brands,
                "ad"     => $ad,
            ];

            return view("pages.ads.create-edit", $data);

        } else {
            return back()->withErrors("Você não possui permissão para modificar este anúncio.");
        }

    }

    /**
     * Valida os dados vindos da requisição
     *
     * @param Request $request
     * @var \Illuminate\Contracts\Validation\Validator $validator
     */
    private function validation(Request $request) {

        $validator = Validator::make($request->all(), [
            'id' => ['nullable', 'required_if:method,PUT', 'exists:ads,id'],
            'brand_id' => ['required', 'exists:brands,id'],
            'vehicle_type_id' => ['required', 'exists:vehicle_types,id'],
            'name' => ['required', 'string', 'max:80'],
            'year' =>  ['required', 'string', 'max:10'],
            'color' => ['required', 'string', 'max:10'],
            'price_per_day' =>  ['required'],
            'informations' => ['nullable', 'string', 'max:1000'],
        ]);

        return $validator;

    }

    /**
     * Insere um novo anúncio no banco de dados
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function insert(Request $request) {

        try {

            $validation = $this->validation($request);

            if (!$validation->fails()) {

                $ad = new Ad();
                $this->save($request, $ad);

                return redirect("my-ads")->with("success", "Anúncio cadastrado com sucesso!");
            }

            return back()->withErrors('Não foi possível criar o anúncio: '. $validation->errors()->first())->withInput();


        } catch (Exception $e) {
            return back()->withErrors("Ocorreu um problema ao tentar criar o anúncio, tente novamente mais tarde ou contate um admnistrador")->withInput();
        }

    }

    /**
     * Atualiza o registro do anúncio no banco de dados
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request) {

        try {

            $user = Auth::user();
            $validation = $this->validation($request);

            if (!$validation->fails()) {

                $ad = Ad::where(["id" => $request->id, "user_id" => $user->id])->first();

                if ($ad) {
                    $this->save($request, $ad);
                    return redirect("my-ads")->with("success", "Anúncio modificado com sucesso!");

                } else {
                    return back()->withErrors('Você não pode modificar esse anúncio')->withInput();
                }

            }

            return back()->withErrors('Não foi possível modificar o anúncio: '. $validation->errors()->first())->withInput();


        } catch (Exception $e) {
            return back()->withErrors("Ocorreu um problema ao tentar modificar o anúncio, tente novamente mais tarde ou contate um admnistrador")->withInput();
        }

    }

    /**
     * Salva os dados do anúncio
     *
     * @param Request $request
     * @param Ad $ad
     */
    private function save(Request $request, Ad $ad) {

        $user = Auth::user();

        $ad->user_id              = $user->id;
        $ad->brand_id             = $request->brand_id;
        $ad->vehicle_type_id      = $request->vehicle_type_id;
        $ad->is_avaliable         = !!$request->is_avaliable;
        $ad->name                 = $request->name;
        $ad->year                 = $request->year;
        $ad->color                = $request->color;
        $ad->price_per_day        = $request->price_per_day;
        $ad->informations         = $request->informations;

        $ad->begin_avaliable_date = Carbon::createFromFormat('d/m/Y', $request->begin_avaliable_date)->toDateString();
        $ad->end_avaliable_date   = Carbon::createFromFormat('d/m/Y', $request->end_avaliable_date)->toDateString();

        $ad->save();
    }

    public function delete($adId) {
        $user = Auth::user();
        $ad = Ad::where(["id" => $adId, "user_id" => $user->id])->first();

        if ($ad) {
            $ad->delete();
            return back()->with("succes", "Anúncio removido com sucesso!");
        }

        return back()->withErrors("Não é possível remover este anúncio.");
    }

    /**
     * Mostra a tela de visualização do Anúncio
     *
     * @param integer $id
     * @return void
     */
    public function info(int $id) {

        $ad = Ad::find($id);

        if ($ad) {

            $data = [
                "ad" => $ad,
            ];

            return view("pages.ads.info", $data);

        } else {
            return back();
        }

    }

    public function get() {
        $users = User::all();
        return response()->json($users);
    }

}
