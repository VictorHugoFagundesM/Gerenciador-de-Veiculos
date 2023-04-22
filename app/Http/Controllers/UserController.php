<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Brand;
use App\Models\VehicleType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;

class UserController extends Controller {

     /**
     * Retorna à tela inicial de aluguéis
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request) {
        return view("pages.profile.profile", ["user" => Auth::user()]);
    }

    /**
     * Valida os dados vindos da requisição
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator $validator
     */
    private function validation(Request $request, $user) {

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255', 'unique:users,phone,'.$user->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        return $validator;

    }

    /**
     * Insere uma nova locação
     *
     * @param Request $request
     * @return void
     */
    public function update(Request $request) {

        try {
            $user = Auth::user();
            $validation = $this->validation($request, $user);

            if (!$validation->fails()) {

                $user->name = $request->name;
                $user->phone = $request->phone;
                if($request->password) $user->password = Hash::make($request->password);

                $user->save();

                return redirect("profile")->with("success", "Dados atualizados com sucesso!");
            }

            return back()->withErrors("Ocorreu um erro ao atualizar os dados: ".$validation->errors()->first());

        } catch (Exception $e) {
            return back()->withErrors("Ocorreu um erro ao atualizar os dados, tente novamente mais tarde ou contate um admnistrador");
        }

    }

}
