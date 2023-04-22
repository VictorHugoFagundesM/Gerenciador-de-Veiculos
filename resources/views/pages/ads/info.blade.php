@extends('layouts.main-layout')

@section('content')

    <div class="row flex-column-reverse flex-lg-row">

        <div class="page page-ad-info col-12 col-lg-7">

            <h3 class="page-header">{{$ad->name}}</h3>
            <div class="page-body">

                @if ($ad->vehicle_type_name)
                    <div class="ad-info">
                        <span>Tipo:</span>
                        <div>{{$ad->vehicle_type_name}}</div>
                    </div>
                @endif

                @if ($ad->brand_name)
                    <div class="ad-info">
                        <span>Marca:</span>
                        <div>{{$ad->brand_name}}</div>
                    </div>
                @endif

                @if ($ad->year)
                    <div class="ad-info">
                        <span>Ano:</span>
                        <div>{{$ad->year}}</div>
                    </div>
                @endif

                @if ($ad->color)
                    <div class="ad-info">
                        <span>Cor:</span>
                        <div>{{$ad->color}}</div>
                    </div>
                @endif

                @if ($ad->informations)
                    <div class="ad-info">
                        <span>Informações:</span>
                        <div>{{$ad->informations}}</div>
                    </div>
                @endif


            </div>

        </div>

        <div class="page page-ad-rent mb-0 col-12 col-lg-4 ml-auto">

            <form class="form-container" method="POST" action="{{ url("rent") }}" data-parsley-validate="">

                @include('components._alert', ['oneError' => true ])
                @csrf
                @method( "POST" )

                <input type="hidden" name="ad_id" value="{{$ad->id}}">

                <div class="form-header row">
                    <h2 class="primary">R${{$ad->price_per_day}} /dia</h2>
                </div>

                <div class="form-body">

                    <div class="form-group mb-2">
                        <label>Data de locação</label>
                        <input type="text" required name="begin_date" class="form-control date">
                    </div>

                    <div class="form-group">
                        <label>Data de devolução</label>
                        <input type="text" required name="end_date" class="form-control date">
                    </div>

                </div>

                <div class="form-footer align-items-center">

                    <div class="total" data-price-per-day={{$ad->price_per_day}}>
                        Total: R$ <span>0</span>
                    </div>

                    <button type="submit" class="btn btn-primary ml-auto">Alugar</button>

                </div>

            </form>

        </div>

    </div>

@endsection
