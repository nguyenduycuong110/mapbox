@extends('frontend.homepage.layout')

@section('content')
    <div id="homepage" class="homepage">
        <div class="button-arrow active" style="">
            <button class="btn-arr">
                <svg class="menu-svg" viewBox="0 0 100 100">
                    <path d="m 30,33 h 40 c 3.722839,0 7.5,3.126468 7.5,8.578427 0,5.451959 -2.727029,8.421573 -7.5,8.421573 h -20">
                    </path>
                    <path d="m 30,50 h 40"></path>
                    <path d="m 70,67 h -40 c 0,0 -7.5,-0.802118 -7.5,-8.365747 0,-7.563629 7.5,-8.634253 7.5,-8.634253 h 20">
                    </path>
                </svg>
            </button>
        </div>
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
