@extends('template')

@php
    $hasContainer = isset($hasContainer) ? $hasContainer : true;
@endphp

@section('header-content')

    <div class="site-header">

        @php
            $user = Auth::user();
        @endphp

        <a href="{{ url('/') }}" class="logo">
            <span></span> <b>Car</b>
        </a>

        <div class="menu">

            <a class="menu-item" href="{{ url('rent-car') }}">Alugar</a>
            <a class="menu-item" href="{{ url('create-ad') }}">Anunciar</a>

            <div class="user-info-container">

                @if ($user)
                    <div class="menu-item user-info drop-menu">

                        {{ $user->name }}

                        <div class="drop-menu-container">

                            <a class="drop-item" href="{{ url('profile') }}">Meu Perfil</a>
                            <a class="drop-item" href="{{ url('my-ads') }}" class="">Meus Anúncios</a>
                            <a class="drop-item" href="{{ url('my-rents') }}" class="">Meus Aluguéis</a>

                            <form class="" method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="drop-item btn btn-outline" class="btn btn-outline" type="submit"> Sair </button>
                            </form>

                        </div>

                    </div>
                @else
                    <a class="menu-item user-info" href="{{ url('login') }}"> Entrar </a>
                @endif

            </div>

        </div>


    </div>

@endsection

@section('body-content')

    <div class="site-body">

        @if ($hasContainer)

            <div class="container">
                @yield('content')
            </div>

        @else
            @yield('content')
        @endif

    </div>

@endsection

@section('footer-content')

    <div class="site-footer">

        <div class="first-row">

            <div class="left-content">
                <span>Rent</span>
                <a class="menu-item" href="{{ url('rent-car') }}">Alugar</a>
                <a class="menu-item" href="{{ url('create-ad') }}">Anunciar</a>
            </div>

            <div class="right-content">
                <a class="menu-item" href="https://www.instagram.com/victor.fagundes1/" target="_blank"><i class="fa-brands fa-linkedin-in"></i></a>
                <a class="menu-item" href="https://www.linkedin.com/in/victor-fagundes-bb797a203/" target="_blank"><i class="fa-brands fa-instagram"></i></a>
            </div>

        </div>

        <div class="second-row">

            <span>
                © Feito por Victor Fagundes
            </span>

        </div>

    </div>

@endsection
