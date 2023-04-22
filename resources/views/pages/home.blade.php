@extends('layouts.main-layout', ["hasContainer" => false, "hasFooter" => false, "hasBg" => !count($ads)])

@section('content')

    <div class="page-home">

        <form class="side-filters" method="GET" action="{{ url('/') }}">

            <div class="filters-header">

                <div>
                    <input class="d-none" type="hidden" name="vehicle_type_name" value="{{$search->vehicle_type_name}}" >
                    <h3 class="mb-0">{{$search->vehicle_type_name ? $search->vehicle_type_name."s" : 'Veículos'}}</h3>
                    <small>{{$ads->total()}} resultado(s) encontrado(s)</small>
                </div>

                <div class="btn-container">
                    <button type="submit" class="btn btn-primary btn-sm">Pesquisar</button>
                </div>
            </div>

            <div class="filters-body">

                <div class="form-group">

                    <label>Marca</label>

                    <select class="form-select"  name="brand_id">

                        <option value="0">Selecione a marca do veículo</option>

                        @foreach ($brands as $b )
                            <option value="{{$b->id}}" {{$search->brand_id == $b->id ? "selected" : '' }}>{{$b->name}}</option>
                        @endforeach

                    </select>

                </div>

                <div class="form-group">

                    <label>Tipo</label>

                    <select class="form-select"  name="vehicle_type_id">

                        @foreach ($types as $t )
                            <option value="{{$t->id}}" {{ $search->vehicle_type_id == $t->id ? "selected" : '' }}>{{$t->name}}</option>
                        @endforeach

                    </select>

                </div>

                {{-- <div class="form-group">

                    <label>Ano</label>

                    <div class="row">

                        <div class="form-group col-6">
                            <input type="text" name="year_range_begin" class="form-control" value="{{$search->year_range_begin}}" placeholder="de" maxlength="4">
                        </div>

                        <div class="form-group col-6">
                            <input type="text" name="year_range_end" class="form-control" value="{{$search->year_range_end}}" placeholder="até" maxlength="4">
                        </div>

                    </div>

                </div> --}}

                <div class="form-group">
                    <label>Cor</label>
                    <input type="text" name="color" class="form-control"  placeholder="Cor do veículo" value="{{$search->color}}" maxlength="20">
                </div>

                <div class="form-group">
                    <label>Preço</label>

                    <div class="row">

                        <div class="form-group col-6">
                            <input type="text" name="price_range_begin" class="form-control col-6" value="{{$search->price_range_begin}}" placeholder="de" maxlength="80">
                        </div>

                        <div class="form-group col-6">
                            <input type="text" name="price_range_end" class="form-control col-6" value="{{$search->price_range_end}}" placeholder="até" maxlength="80">
                        </div>

                    </div>

                </div>

                <div class="form-group">

                    <label>Data de disponibilidade</label>

                    <div class="row">

                        <div class="form-group col-6">
                            <input type="text"
                                name="begin_avaliable_date " class="form-control date"
                                placeholder="de"
                                maxlength="10"
                            >
                        </div>

                        <div class="form-group col-6">
                            <input type="text"
                                name="end_avaliable_date" class="form-control date"
                                placeholder="até"
                                maxlength="10"
                            >
                        </div>

                    </div>

                </div>

            </div>

        </form>

        <div class="items-container">

            @if (count($ads))

                <div class="banner">

                    @php
                        $bannerImages = ["Carro", "Bicicleta"];
                        $bannerImage = in_array($search->vehicle_type_name, $bannerImages) ? $search->vehicle_type_name : "Default";
                    @endphp


                    <img src="{{asset("img/$bannerImage.jpg")}}">
                </div>

                <div class="items">

                    @foreach ( $ads as $ad )

                        <a href="{{url('ad-info/'.$ad->id)}}" class="card" style="width: 18rem;">

                            <img class="card-img-top" src="{{ asset($ad->image_path ?? 'img/default-image.jpg')  }}" alt="Card image cap">

                            <div class="card-body">

                                <h6 class="card-title">{{$ad->name}}</h6>
                                <small>{{$ad->vehicle_type_name. " - " . $ad->brand_name}}</small>

                                <p class="card-text mt-3 mb-0">
                                    R$
                                    {{$ad->price_per_day}}
                                    <span>/dia</span>
                                </p>
                                <small>{{$ad->year}}</small>

                            </div>

                        </a>

                    @endforeach

                </div>

                @if ($ads->links())

                    <div class="pagination-container">
                        {{ $ads->links() }}
                    </div>

                @endif

            @else

                <div class="no-results">
                    <img class="no-results-image" src="{{asset('img/Curious-cuate.png')}}">
                    <h5 class="primary text-center">Nenhum anúncio encontrado</h5>
                    <div class="text-center">Não foram encontrados anúncios para os filtros selecionados. </div>
                </div>

            @endif

        </div>

    </div>

@endsection
