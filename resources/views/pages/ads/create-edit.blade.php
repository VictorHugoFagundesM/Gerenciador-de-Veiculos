@extends('layouts.main-layout')

@section('content')

    <div class="page ad-page">

        <form class="form-container" method="POST" action="{{ url('ad') }}" data-parsley-validate="">

            @include('components._alert', ['oneError' => true ])
            @method( $ad->id ? "PUT" : "POST" )

            <input type="hidden" name="id" value="{{$ad->id}}">

            @csrf

            <div class="form-header">
                <h3>{{ $ad->id ? "Anúncio" : "Novo Anúncio"}}</h3>
                <span>{{ $ad->id ? "Modifique as informações do anúncio" :"Insira as informações para cadastrar um novo anúncio"}}</span>
            </div>

            <div class="form-body">

                <div class="row">

                    <div class="form-group form-check col-12">

                        <input class="form-check-input" type="checkbox" value="1" checked {{ !old('is_avaliable', $ad->is_avaliable) || !$ad->id ? '' : 'checked' }} id="is_avaliable">

                        <label class="form-check-label" for="is_avaliable">
                            Anúncio Ativo?
                        </label>

                    </div>

                </div>

                <div class="row">

                    <div class="form-group col-12 col-md-6">
                        <label>Nome</label>
                        <input type="text" name="name" class="form-control" required placeholder="Informe o nome do veículo" value="{{old('name', $ad->name)}}" maxlength="80">
                    </div>

                    <div class="form-group col-12 col-md-6">
                        <label>Cor</label>
                        <input type="text" name="color" class="form-control" required placeholder="Informe a cor do veículo" value="{{old('color', $ad->color)}}" maxlength="20">
                    </div>

                </div>

                <div class="row">

                    <div class="form-group col-12 col-md-6">

                        <label>Tipo</label>

                        <select class="form-select col-12 col-md-6" required name="vehicle_type_id">

                            <option selected>Selecione o tipo do veículo</option>

                            @foreach ($types as $t )
                                <option value="{{$t->id}}" {{ old('vehicle_type_id', $ad->vehicle_type_id) == $t->id ? "selected" : '' }}>{{$t->name}}</option>
                            @endforeach

                        </select>

                    </div>

                    <div class="form-group col-12 col-md-6">

                        <label>Marca</label>

                        <select class="form-select col-12 col-md-6" required name="brand_id">

                            <option selected>Selecione a marca do veículo</option>

                            @foreach ($brands as $b )
                                <option value="{{$b->id}}" {{ old('brand_id', $ad->brand_id) == $b->id ? "selected" : '' }}>{{$b->name}}</option>
                            @endforeach

                        </select>

                    </div>

                </div>

                <div class="row">

                    <div class="form-group col-12 col-md-6">
                        <label>Ano</label>
                        <input type="text" name="year" class="form-control" required placeholder="Informe o ano do veículo" value="{{old('year', $ad->year)}}" maxlength="10">
                    </div>

                    <div class="form-group col-12 col-md-6">
                        {{-- TODO colocar máscara de preço --}}
                        <label>Preço do aluguel (diária)</label>
                        <input type="number" name="price_per_day" class="form-control" required placeholder="Informe a cor do veículo" value="{{old('price_per_day', $ad->price_per_day)}}">
                    </div>

                </div>

                <div class="row">

                    <div class="form-group col-12 col-md-6">
                        <label>Data inicial</label>
                        @php
                            $beginDate = $ad->end_avaliable_date ? Carbon\Carbon::parse($ad->begin_avaliable_date) : '';
                        @endphp
                        <input type="text"
                            name="begin_avaliable_date" class="form-control date"
                            required placeholder="Disponível a partir de"
                            value="{{old('begin_avaliable_date', $beginDate) ? old('begin_avaliable_date', $beginDate)->format('d/m/Y') : ''}}"
                            maxlength="10"
                        >
                    </div>

                    <div class="form-group col-12 col-md-6">
                        <label>Data final</label>
                        @php
                            $endDate = $ad->end_avaliable_date ? Carbon\Carbon::parse($ad->begin_avaliable_date) : '';
                        @endphp
                        <input type="text"
                            name="end_avaliable_date" class="form-control date" required
                            placeholder="Disponível até"
                            value="{{old('end_avaliable_date', $endDate) ? old('end_avaliable_date', $endDate)->format('d/m/Y') : ''}}"
                            maxlength="10"
                        >
                    </div>

                </div>

                <div class="row">

                    <div class="form-group col-12">
                        <label>Informações extras</label>
                        <textarea class="form-control" name="informations" placeholder="Insira informações extras e pertinentes sobre o veículo...">{{old('informations', $ad->informations)}}</textarea>
                    </div>
                </div>

            </div>

            <div class="form-footer">
                <a href="{{ url()->previous() }}" class="btn btn-outline-dark mr-auto">Voltar</a>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>

        </form>

    </div>

@endsection
