@extends('frontend.homepage.layout')
@section('content')

    <div class="post-detail">
        @if(!empty($postCatalogue->image))
            <span class="image img-cover"><img src="{{ image($postCatalogue->image) }}" alt=""></span>
        @endif
        @include('frontend.component.breadcrumb', ['model' => $postCatalogue, 'breadcrumb' => $breadcrumb])
        <div class="uk-container uk-container-center">
            <div class="uk-grid uk-grid-medium">
                <div class="uk-width-large-3-4">
                    <div class="detail-wrapper">
                        <div class="info">
                            <h1 class="post-title">{{ $post->name }}</h1>
                        </div>
                        <div class="content">
                            {!! $post->content !!}
                        </div>
                    </div>
                </div>
                <div class="uk-width-large-1-4">
                    @include('frontend.component.post-aside')
                </div>
            </div>
            <div class="panel-relate">
                @if(!is_null($asidePost))
                    <div class="panel-head">
                        <h2 class="heading-1"><span>Các bài viết liên quan</span></h2>
                    </div>
                    <div class="panel-body">
                        <div class="uk-grid uk-grid-medium">
                            @foreach($asidePost as $key => $post)
                                <div class="uk-width-medium-1-3 mb20">
                                    @php
                                        $name = $post->languages->first()->pivot->name;
                                        $description = $post->languages->first()->pivot->description;
                                        $canonical = write_url($post->languages->first()->pivot->canonical);
                                        $image = image($post->image);
                                        if($key > 10) break;
                                    @endphp
                                    <div class="relate-item uk-clearfix">
                                        <a href="{{ $canonical }}" class="image img-cover"><img src="{{ $image }}" alt="{{ $name }}"></a>
                                        <div class="info">
                                            <h3 class="title"><a href="{{ $canonical }}" title="{{ $name }}">{{ $name }}</a></h3>
                                            <div class="description">
                                                {!! $description !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
