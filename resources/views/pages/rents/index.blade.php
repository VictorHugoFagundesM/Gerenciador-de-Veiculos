@extends('layouts.main-layout')

@section('content')

    <div class="page page-ad">

        <div class="page-header">

            @include('components._alert', ['oneError' => true ])

            <div class="d-flex mb-3">
                <h3 class="mb-0">Meus alugéis</h3>
            </div>

            @include('components._filter',[
                "path" => "my-rents",
                "placeholder" => "Pesquise por nome, tipo, marca ou cor do veículo",
                "search" => $search,
                "paginate" => $paginate
            ])

        </div>

        <div class="page-body">

            <div class="items-container">

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

                            </div>

                        </div>

                    @endforeach

                @else

                    <div class="no-results">
                        <img class="no-results-image" src="{{asset('img/Curious-cuate.png')}}">
                        <div class="text-center w-100 mb-5"> Nenhum dado encontrado para os filtros selecionados. </div>
                    </div>

                @endif

            </div>

            <div class="pagination-container">
                {{ $ads->links() }}
            </div>

        </div>

    </div>

@endsection
