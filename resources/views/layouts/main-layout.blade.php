@extends('template')

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
            <a class="menu-item" href="{{ url('ad') }}">Anunciar</a>

            <div class="user-info-container">

                @if ($user)
                    <div class="menu-item user-info">{{ $user->name }}</div>
                @else
                    <a class="menu-item user-info" href="{{ 'login' }}"> Entrar </a>
                @endif

            </div>

        </div>


    </div>

@endsection

@section('body-content')

    <div class="site-body">

        @yield('content')

    </div>

@endsection

@section('footer-content')

    <div class="site-footer">

        <div class="first-row">

            <div class="left-content">
                <span>Rent</span>
                <a class="menu-item" href="{{ url('rent-car') }}">Alugar</a>
                <a class="menu-item" href="{{ url('ad') }}">Anunciar</a>
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
