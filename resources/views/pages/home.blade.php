@extends('layouts.main-layout', ["hasContainer" => false])

@section('content')

    <div class="page-home">

        <div class="side-filters">

            <h3>Carro</h3>

            <select name="brand_id"></select>
            <select name="vehicle_type_id"></select>
            <select name="year"></select>
            <select name="color"></select>
            <select name="price_per_day"></select>
            <select name="begin_avaliable_date"></select>
            <select name="end_avaliable_date"></select>

        </div>

        <div class="side-filters items-container">

            @if (count($ads))

                @foreach ( $ads as $ad )

                    <div class="card" style="width: 18rem;">

                        <img class="card-img-top" src="{{ asset($ad->image_path ?? 'img/default-image.jpg')  }}" alt="Card image cap">

                        <div class="card-body">

                            <h5 class="card-title">{{$ad->name. " - " . $ad->year}}</h5>
                            <p>{{$ad->vehicle_type_name. " - " . $ad->brand_name}}</p>

                            @if ($ad->informations)
                                <p class="card-text">{{$ad->informations}}</p>
                            @endif

                            <div class="row">
                                <a href="{{url("edit-ad/$ad->id")}}" class="btn btn-outline-dark col-5 ml-auto mr-auto">Editar</a>
                                <a href="#" class="btn btn-primary col-5 ml-auto mr-auto">Ver</a>
                            </div>

                        </div>

                    </div>

                @endforeach

            @else

                <div class="no-results">
                    <img class="no-results-image" src="{{asset('img/Curious-cuate.png')}}">
                    <div class="text-center w-100 mb-5"> Nenhum anúncio encontrado para os filtros selecionados. </div>
                </div>

            @endif

        </div>

        <div class="pagination-container">
            {{ $ads->links() }}
        </div>

    </div>

@endsection
