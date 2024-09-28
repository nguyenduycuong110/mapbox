@extends('frontend.homepage.layout')
@section('content')
    <div class="tag-controller pt50 panel-news">
        <div class="uk-container uk-container-center">
            <div class="panel-head">
                <h2 class="heading-1">
                    <span>Chi tiết sự kiện</span>
                </h2>
            </div>
            <div class="panel-body">
                <div class="event-item">
                    <p class="name">{{ $event[0]['name'] }}</p>
                    <p class="description">{{ $event[0]['description'] }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection