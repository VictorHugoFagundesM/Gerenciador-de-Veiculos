<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\Rent;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
     * Obtém os dados de aluguéis do usuário
     *
     * @param Request $request
     * @return void
     */
    public function get (Request $request) {

        try {

            $user = Auth::user();
            $rents = Rent::searchByUser($user->id)->get();

            $data = [
                "qty" => count($rents),
                "rents" => $rents,
            ];

            return response()->json($data, Response::HTTP_OK);

        } catch (Exception $e) {
            return response($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    /**
     * Valida os dados vindos da requisição
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator $validator
     */
    private function validation(Request $request, Ad $ad = null, $rent = null) {

        $data = array_merge(["method" => $request->method()], $request->all());
        $validator = Validator::make($data, [
            'id' => ['required_if:method,PUT', 'exists:rents,id'],
            'ad_id' => ['required_if:method,POST', 'prohibited_if:method,PUT', 'exists:ads,id'],
            'begin_date' => ['required_if:method,POST','date_format:d/m/Y'],
            'end_date' => ['required_if:method,POST','date_format:d/m/Y'],
        ], [],
        [
            'begin_date' => 'Data de locação',
            'end_date' => 'Data de devolução',
        ]);

        $validator->after(function($validator) use ($request, $ad, $rent) {

            if ($ad && !$ad->is_avaliable) {
                $validator->errors()->add('ad_id', 'O carro não está disponível para locação.');
            }

            if ($request->begin_date && $request->end_date) {

                $beginDate = Carbon::createFromFormat('d/m/Y', $request->begin_date);
                $endDate   = Carbon::createFromFormat('d/m/Y', $request->end_date);

                if (!$endDate->gt($beginDate)) {
                    $validator->errors()->add('end_date', 'A data de devolução deve ser superior a data de locação.');
                }

            } else if ($request->begin_date && $rent) {

                $beginDate = Carbon::createFromFormat('d/m/Y', $request->begin_date);
                $endDate   = Carbon::create($rent->end_date);

                if (!$endDate->gt($beginDate)) {
                    $validator->errors()->add('end_date', 'A data de devolução deve ser superior a data de locação.');
                }

            } else if ($request->end_date && $rent) {

                $beginDate = Carbon::create($rent->begin_date);
                $endDate   = Carbon::createFromFormat('d/m/Y', $request->end_date);

                if (!$endDate->gt($beginDate)) {
                    $validator->errors()->add('end_date', 'A data de devolução deve ser superior a data de locação.');
                }

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

            $ad = Ad::find($request->ad_id);
            $validation = $this->validation($request, $ad);

            if (!$validation->fails()) {

                $rent = new Rent();
                $this->save($request, $rent, $ad);

                $ad->is_avaliable = false;
                $ad->save();

                return response()->json($rent, Response::HTTP_OK);
            }

            return response($validation->errors()->first(), Response::HTTP_BAD_REQUEST);

        } catch (Exception $e) {
            return response($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    /**
     * Atualiza o registro da locação no banco de dados
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request) {

        try {

            $user = auth('api')->user();
            $rent = null;

            if ($request->id) {
                $rent = Rent::where("id", $request->id)->where(function ($rent) use ($user){
                    $rent->where  ("hirer_id", $user->id);
                    $rent->orWhere("renter_id", $user->id);
                })->first();
            }

            $validation = $this->validation($request, null, $rent);

            if (!$validation->fails()) {

                if ($rent) {

                    $this->save($request, $rent);
                    return response()->json($rent, Response::HTTP_OK);

                } else {
                    return response('Locação não encontrada', Response::HTTP_BAD_REQUEST);
                }
            }

            return response($validation->errors()->first(), Response::HTTP_BAD_REQUEST);

        } catch (Exception $e) {
            return response($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    /**
     * Salva os dados da locação
     *
     * @param Request $request
     * @param $rent
     * @param Ad $ad
     */
    private function save(Request $request, $rent, Ad $ad = null) {

        $user = Auth::user();

        if($request->begin_date) $rent->begin_date = Carbon::createFromFormat('d/m/Y', $request->begin_date)->toDateString();
        if($request->end_date) $rent->end_date   = Carbon::createFromFormat('d/m/Y', $request->end_date)->toDateString();

        if ($request->method == "POST") {
            $rent->ad_id = $ad->id;
            $rent->renter_id = $ad->user_id;
            $rent->hirer_id = $user->id;
        }

        $rent->save();

    }

    /**
     * Apaga o registro do aluguel
     *
     * @param [type] $adId
     */
    public function delete($id) {

        try {
            $user = auth('api')->user();

            $rent = Rent::where("id", $id)->where(function ($rent) use ($user){
                $rent->where  ("hirer_id", $user->id);
                $rent->orWhere("renter_id", $user->id);
            })->first();

            if ($rent) {

                $rent->delete();
                return response("Locação removida com sucesso!");
            }
            return response("Locação não encontrada.", Response::HTTP_BAD_REQUEST);

        } catch (Exception $e) {
            return response($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

}
