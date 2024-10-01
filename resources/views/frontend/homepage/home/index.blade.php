@extends('frontend.homepage.layout')

@section('content')
    <div id="homepage">
        @include('frontend.component.sidebar',['cities' => $cities])
        <div 
            id="mapContainer"
            data-zoom="{{ $system['location_zoom'] }}"
            data-lat="{{ $system['location_lat'] }}"
            data-long="{{ $system['location_long'] }}"
        >
        </div>
    </div>
    <script>
        var cities = @json($cities);
    </script>
@endsection
