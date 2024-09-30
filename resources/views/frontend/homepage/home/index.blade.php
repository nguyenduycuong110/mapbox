@extends('frontend.homepage.layout')

@section('content')
    <div 
        id="mapContainer"
        data-lat="{{ $system['location_lat'] }}"
        data-long="{{ $system['location_long'] }}"
    >
    </div>
    <script>
        var cities = @json($cities);
    </script>
@endsection
