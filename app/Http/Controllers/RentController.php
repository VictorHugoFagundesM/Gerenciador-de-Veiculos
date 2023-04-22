<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Rent;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

/**
 * Controller da entidade rents
 *
 * @author Victor Hugo Fagundes <victorhugofmiranad@gmail.com>
 * @since 21/04/2023
 * @version 1.0.0
 */
class RentController extends Controller {

    /**
     * Retorna à tela inicial de aluguéis
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request) {
        $paginate = $request->paginate ?? 10;
        $user = Auth::user();
        $ads = Ad::getByRent($user->id, $request)->paginate($paginate);

        $data = [
            "ads" => $ads,
            "search" => $request->search,
            "paginate" => $paginate
        ];

        return view("pages.rents.index", $data);
    }

    /**
     * Valida os dados vindos da requisição
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator $validator
     */
    private function validation(Request $request) {

        $validator = Validator::make($request->all(), [
            'id' => ['nullable', 'required_if:method,PUT', 'exists:rents,id'],
            'ad_id' => ['required', 'exists:ads,id'],
            'begin_date' => ['required','date_format:d/m/Y'],
            'end_date' => ['required','date_format:d/m/Y'],
        ], [],
        [
            'begin_date' => 'Data de locação',
            'end_date' => 'Data de devolução',
        ]);

        $validator->after(function($validator) use ($request) {

            $beginDate = Carbon::createFromFormat('d/m/Y', $request->begin_date);
            $endDate   = Carbon::createFromFormat('d/m/Y', $request->end_date);

            if (!$endDate->gt($beginDate)) {
                $validator->errors()->add('end_date', 'A data de devolução deve ser superior a data de locação.');
            }

        });

        return $validator;

    }

    /**
     * Insere uma nova locação
     *
     * @param Request $request
     * @return void
     */
    public function insert(Request $request) {

        try {

            $validation = $this->validation($request);

            if (!$validation->fails()) {

                $rent = new Rent();
                $ad = Ad::find($request->ad_id);

                $this->save($request, $rent, $ad);

                return redirect("my-rents")->with("success", "Anúncio modificado com sucesso!");
            }

            return back()->withErrors("Ocorreu um erro ao relizar a locação: ".$validation->errors()->first());

        } catch (Exception $e) {
            return back()->withErrors("Ocorreu um erro ao relizar a locação, tente novamente mais tarde ou contate um admnistrador");
        }

    }

    /**
     * Salva os dados da locação
     *
     * @param Request $request
     * @param Rent $rent
     * @param Ad $ad
     */
    private function save(Request $request, Rent $rent, Ad $ad) {

        $user = Auth::user();

        $rent->begin_date = Carbon::createFromFormat('d/m/Y', $request->begin_date)->toDateString();
        $rent->end_date   = Carbon::createFromFormat('d/m/Y', $request->end_date)->toDateString();
        $rent->ad_id = $ad->id;
        $rent->renter_id = $ad->user_id;
        $rent->hirer_id = $user->id;

        $rent->save();

    }

}
