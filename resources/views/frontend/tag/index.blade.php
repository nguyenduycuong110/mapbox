@extends('frontend.homepage.layout')
@section('content')
    <div class="tag-controller pt50 panel-news">
        <div class="uk-container uk-container-center">
            <div class="panel-head">
                <h2 class="heading-1">
                    <span>Tag</span>
                </h2>
            </div>
            <div class="panel-body">
                @if(!is_null($listPost))
                    <div class="uk-grid uk-grid-medium">
                        @foreach ($listPost as $key => $val)
                            <div class="uk-width-medium-1-4">
                                <div class="tag-item news-item mb30">
                                    <a href="{{ write_url($val->canonical) }}">
                                        <div class="thumb image">
                                            <img src="{{ $val->image }}" alt="">
                                        </div>
                                        <div class="wrapper">
                                            <p class="title">{{ $val->name }}</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection