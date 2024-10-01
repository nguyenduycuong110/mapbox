@extends('frontend.homepage.layout')
@section('content')
    <div class="location-container">
        @include('frontend.component.sidebar',['cities' => $list_city])
        <div 
            id="mapLocation"
            data-zoom = "{{ $system['location_zoom'] }}"
            data-lat = "{{ $city->lat }}"
            data-long = "{{ $city->long }}"
        >
        </div>
    </div>
    <script>
        var homeStay = @json($homeStay);
    </script>
@endsection