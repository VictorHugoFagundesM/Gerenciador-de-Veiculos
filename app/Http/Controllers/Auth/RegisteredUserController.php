<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, $fromApi = null)
    {
        try {

            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'phone' => ['required', 'string', 'max:255', 'unique:users'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            if (!$validator->fails()) {

                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'password' => Hash::make($request->password),
                ]);

                event(new Registered($user));

                Auth::login($user);

                if ($fromApi) {
                    return response()->json($user, Response::HTTP_OK);

                } else {
                    return redirect(RouteServiceProvider::HOME);
                }

            }

            if ($fromApi) {
                return response()->json($validator->errors()->first(), Response::HTTP_BAD_REQUEST);

            } else {
                return back()->withErrors('Não foi possível completar o registro: '. $validator->errors()->first())->withInput();
            }

        } catch (Exception $e) {

            if($fromApi) {
                return response()->json($e->getMessage(), Response::HTTP_BAD_REQUEST);

            } else {
                return back()->withErrors('Ocorreu um problema inesperado ao completar o registro, tente novamente mais tarde ou contate um admnistrador.')->withInput();
            }

        }
    }
}
