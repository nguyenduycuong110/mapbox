<div class="ibox w">
    <div class="ibox-title">
        <h5>{{ __('messages.parent') }}</h5>
    </div>
    <div class="ibox-content">
        <div class="row mb15">
            <div class="col-lg-12">
                <div class="form-row">
                    <select name="post_catalogue_id" class="form-control setupSelect2" id="">
                        @foreach($dropdown as $key => $val)
                        <option {{ 
                            $key == old('post_catalogue_id', (isset($post->post_catalogue_id)) ? $post->post_catalogue_id : '') ? 'selected' : '' 
                            }} value="{{ $key }}">{{ $val }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        @php
            $catalogue = [];
            if(isset($post)){
                foreach($post->post_catalogues as $key => $val){
                    $catalogue[] = $val->id;
                }
            }
        @endphp
        <div class="row">
            <div class="col-lg-12">
                <div class="form-row">
                    <label class="control-label">{{ __('messages.subparent') }}</label>
                    <select multiple name="catalogue[]" class="form-control setupSelect2" id="">
                        @foreach($dropdown as $key => $val)
                        <option 
                            @if(is_array(old('catalogue', (
                                isset($catalogue) && count($catalogue)) ?   $catalogue : [])
                                ) && isset($post->post_catalogue_id) && $key !== $post->post_catalogue_id &&  in_array($key, old('catalogue', (isset($catalogue)) ? $catalogue : []))
                            )
                            selected
                            @endif value="{{ $key }}">{{ $val }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="ibox w">
    <div class="ibox-title">
        <div class="uk-flex uk-flex-middle uk-flex-space-between">
            <h5>Chọn loại bài viết <span class="text-danger">(*)</span></h5>
        </div>
    </div>
    <div class="ibox-content">
        <div class="row mb15">
            <div class="col-lg-12">
                @php
                    $type = request('type') ?: old('type');
                @endphp
                <select name="type" class="form-control setupSelect2 ml10">
                    @foreach(config('apps.general.type') as $key => $val)
                        <option {{ 
                            $key == old('type', (isset($post->type)) ? $post->type : '') ? 'selected' : '' 
                            }}  value="{{ $key }}">{{ $val }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
<div class="ibox w">
    <div class="ibox-title">
        <div class="uk-flex uk-flex-middle uk-flex-space-between">
            <h5>Tags</h5>
            <a href="" class="upload-video">+ Cập nhật tag</a>
        </div>
    </div>

    <div class="ibox-content">
        <div class="row mb15">
            <div class="col-lg-12">
                <select 
                    name="tag[]" 
                    class="form-control search-field setupSelect2" 
                    id="tagSearch" 
                    multiple="multiple"
                >
                @if(isset($post))
                    @foreach ($post->tag_post as $key => $val)
                        <option value="{{ $val->tag_id }}" selected > {{ $val->name }} </option>
                    @endforeach
                @endif
                </select>
            </div>
        </div>
    </div>
</div>
<div class="ibox w">
    <div class="ibox-title">
        <div class="uk-flex uk-flex-middle uk-flex-space-between">
            <h5>Video Clip</h5>
            <a href="" class="upload-video">Upload Video</a>
        </div>
    </div>
    <div class="ibox-content">
        <div class="row mb15">
            <div class="col-lg-12">
                <div class="form-row">
                    <textarea name="video" class="form-control video-target" style="height:168px;">{{ old('video', (isset($post->video)) ? $post->video : '') }}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>

@include('backend.dashboard.component.publish', ['model' => ($post) ?? null])
