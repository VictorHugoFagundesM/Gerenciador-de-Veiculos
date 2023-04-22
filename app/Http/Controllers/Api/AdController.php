<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\Brand;
use App\Models\User;
use App\Models\VehicleType;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

/**
 * Controler da api da entidade ads
 *
 * @author Victor Hugo Fagundes Miranda <victorhugofmiranda@gmail.com>
 * @since 16/04/2023
 * @version 1.0.0
 */
class AdController extends Controller {

    /**
     * Retorna os anúncios relacionados ao usuário
     */
    public function get(Request $request) {

        try {
            $user = auth('api')->user();
            $ads = Ad::search($user->id, $request)->get();

            $data = [
                "qty" => count($ads),
                "ads" => $ads
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
     * @var \Illuminate\Contracts\Validation\Validator $validator
     */
    private function validation(Request $request, Ad $ad = null) {

        $data = array_merge(["method" => $request->method()], $request->all());

        $validator = Validator::make($data, [
            'id' => ['required_if:method,PUT', 'exists:ads,id'],
            'brand_id' => ['required_if:method,POST', 'exists:brands,id'],
            'vehicle_type_id' => ['required_if:method,POST', 'exists:vehicle_types,id'],
            'is_avaliable' => ['nullable'],
            'name' => ['required_if:method,POST', 'string', 'max:80'],
            'year' =>  ['required_if:method,POST', 'string', 'max:10'],
            'color' => ['required_if:method,POST', 'string', 'max:10'],
            'price_per_day' =>  ['required_if:method,POST'],
            'informations' => ['nullable', 'string', 'max:1000'],
            "begin_avaliable_date" => ['required_if:method,POST', 'date_format:d/m/Y'],
            "end_avaliable_date" => ['required_if:method,POST', 'date_format:d/m/Y'],
        ]);

        $validator->after(function($validator) use ($request, $ad) {

            if ($request->begin_avaliable_date && $request->end_avaliable_date) {

                $beginDate = Carbon::createFromFormat('d/m/Y', $request->begin_avaliable_date);
                $endDate   = Carbon::createFromFormat('d/m/Y', $request->end_avaliable_date);

                if (!$endDate->gt($beginDate)) {
                    $validator->errors()->add('end_date', 'A data inicial deve ser superior a data final.');
                }

            } else if ($request->begin_avaliable_date && $ad) {

                $beginDate = Carbon::createFromFormat('d/m/Y', $request->begin_avaliable_date);
                $endDate   = Carbon::create($ad->end_avaliable_date);

                if (!$endDate->gt($beginDate)) {
                    $validator->errors()->add('end_date', 'A data inicial deve ser superior a data final.');
                }

            } else if ($request->end_avaliable_date && $ad) {

                $beginDate = Carbon::create($ad->begin_avaliable_date);
                $endDate   = Carbon::createFromFormat('d/m/Y', $request->end_avaliable_date);

                if (!$endDate->gt($beginDate)) {
                    $validator->errors()->add('end_date', 'A data inicial deve ser superior a data final.');
                }

            }

        });

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
                return response()->json($ad, Response::HTTP_OK);
            }

            return response($validation->errors()->first(), Response::HTTP_BAD_REQUEST);

        } catch (Exception $e) {
            return response($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
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

            $user = auth('api')->user();
            $ad = Ad::where(["id" => $request->id, "user_id" => $user->id])->first();
            $validation = $this->validation($request, $ad);

            if (!$validation->fails()) {

                if ($ad) {
                    $this->save($request, $ad);
                    return response()->json($ad, Response::HTTP_OK);

                } else {
                    return response('Anúncio não encontrado', Response::HTTP_BAD_REQUEST);
                }
            }

            return response($validation->errors()->first(), Response::HTTP_BAD_REQUEST);

        } catch (Exception $e) {
            return response($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    /**
     * Salva os dados do anúncio
     *
     * @param Request $request
     * @param Ad $ad
     */
    private function save(Request $request, Ad $ad) {

        $user = auth('api')->user();

        $ad->user_id = $user->id;

        if ($request->is_avaliable)     $ad->is_avaliable    = !!$request->is_avaliable;
        if ($request->brand_id)         $ad->brand_id        = $request->brand_id;
        if ($request->vehicle_type_id)  $ad->vehicle_type_id = $request->vehicle_type_id;
        if ($request->name)             $ad->name            = $request->name;
        if ($request->year)             $ad->year            = $request->year;
        if ($request->color)            $ad->color           = $request->color;
        if ($request->price_per_day)    $ad->price_per_day   = $request->price_per_day;
        if ($request->informations)     $ad->informations    = $request->informations;

        if ($request->begin_avaliable_date )$ad->begin_avaliable_date = Carbon::createFromFormat('d/m/Y', $request->begin_avaliable_date)->toDateString();
        if ($request->end_avaliable_date )$ad->end_avaliable_date   = Carbon::createFromFormat('d/m/Y', $request->end_avaliable_date)->toDateString();

        $ad->save();
    }

    /**
     * Apaga o registro do anúncio
     *
     * @param [type] $adId
     */
    public function delete($adId) {

        try {
            $user = auth('api')->user();
            $ad = Ad::where(["id" => $adId, "user_id" => $user->id])->first();

            if ($ad) {
                $ad->delete();
                return response("Anúncio removido com sucesso!");
            }
            return response("Anúncio não encontrado.", Response::HTTP_BAD_REQUEST);

        } catch (Exception $e) {
            return response($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

}
