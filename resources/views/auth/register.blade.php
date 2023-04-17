@extends('layouts.main-layout')

@section('content')

    <div class="page page-register">

        <form class="form-container" method="POST" url="{{ url('register') }}" data-parsley-validate="">

            @include('components._alert', ['oneError' => true ])
            @csrf

            <div class="form-header">
                <h3>Cadastrar</h3>
                <span>Cadastre-se seus dados para alugar ou anunciar um veículo!</span>
            </div>

            <div class="form-body">

                <div class="row">

                    <div class="form-group col-12 col-md-6">
                        <label>Nome</label>
                        <input type="text" name="name" class="form-control" required placeholder="Informe seu nome" maxlength="60">
                    </div>

                    <div class="form-group col-12 col-md-6">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required placeholder="Informe o email" maxlength="30">
                    </div>

                </div>

                <div class="row">
                    {{-- TODO colocar máscara de telefone --}}
                    <div class="form-group col-12 col-md-6">
                        <label>Telefone</label>
                        <input type="phone" name="phone" class="form-control" required placeholder="Informe o telefone" maxlength="12">
                    </div>

                </div>

                <div class="row">

                    <div class="form-group col-12 col-md-6">
                        <label>Senha</label>
                        <input type="password" name="password" id="password" class="form-control" minlength="8" required placeholder="Informe a senha">
                    </div>

                    <div class="form-group col-12 col-md-6">
                        <label>Confirmar Senha</label>
                        <input type="password" name="new-password" class="form-control" required minlength="8" placeholder="Informe a senha" data-parsley-equalto="#password">
                    </div>

                </div>

            </div>

            <div class="form-footer">
                <a href="{{ url('login') }}" class="btn btn-outline-dark mr-auto">Voltar</a>
                <button type="submit" class="btn btn-primary">Entrar</button>
            </div>

        </form>

    </div>

@endsection
