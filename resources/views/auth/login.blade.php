@extends('layouts.main-layout')

@section('content')

    <div class="page page-login">

        <form class="form-container login" method="POST" url="{{ url("login") }}" data-parsley-validate="">

            @include('components._alert', ['oneError' => true ])
            @csrf

            <div class="form-header">
                <h3>Login</h3>
                <span>Digite o e-mail e senha para fazer login</span>
            </div>

            <div class="form-body">

                <div class="row">

                    <div class="form-group col-12">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required placeholder="Informe o email">
                    </div>

                </div>

                <div class="row">

                    <div class="form-group col-12">
                        <label>Senha</label>
                        <input type="password" name="password" class="form-control" required minlength="8" placeholder="Informe a senha">
                    </div>

                </div>

                <div class="row mt-2">
                    <a class="primary" href="{{ url('forgot-password') }}">Esqueci minha senha</a>
                </div>

                <div class="row">
                    <a class="primary font-weight-bold" href="{{ url('register') }}"><span>Não possui Conta?</span> Crie aqui!</a>
                </div>

            </div>

            <div class="form-footer">
                <button type="submit" class="btn btn-primary col-12 col-md-3">Entrar</button>
            </div>

        </form>

    </div>

@endsection
