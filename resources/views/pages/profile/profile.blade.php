@extends('layouts.main-layout')

@section('content')

    <div class="page page-profile">

        <form class="form-container" method="POST" url="{{ url('profile') }}" data-parsley-validate="">

            @include('components._alert', ['oneError' => true ])
            @csrf
            @method("PUT")

            <div class="form-header">
                <h3>Perfil</h3>
            </div>

            <div class="form-body">

                <div class="row">

                    <div class="form-group col-12 col-md-6">
                        <label>Nome</label>
                        <input type="text" name="name" class="form-control" required value="{{old('name', $user->name)}}" placeholder="Informe seu nome" maxlength="60">
                    </div>

                    <div class="form-group col-12 col-md-6">
                        <label>Email</label>
                        <input type="email" class="form-control" value="{{$user->email}}" disabled>
                    </div>

                </div>

                <div class="row">
                    {{-- TODO colocar máscara de telefone --}}
                    <div class="form-group col-12 col-md-6">
                        <label>Telefone</label>
                        <input type="phone" name="phone" class="form-control" value="{{old('phone', $user->phone)}}" required placeholder="Informe o telefone" maxlength="12">
                    </div>

                </div>

                <div class="row">

                    <div class="form-group col-12 col-md-6">
                        <label>Senha</label>
                        <input type="password" name="password" id="password" class="form-control" minlength="8" placeholder="Informe a senha">
                    </div>

                    <div class="form-group col-12 col-md-6">
                        <label>Confirmar Senha</label>
                        <input type="password" name="password_confirmation" class="form-control" minlength="8" placeholder="Informe a senha" data-parsley-equalto="#password">
                    </div>

                </div>

            </div>

            <div class="form-footer">
                <a href="{{ url('/') }}" class="btn btn-outline-dark mr-auto">Voltar</a>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>

        </form>

    </div>

@endsection
