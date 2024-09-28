@include('backend.dashboard.component.breadcrumb', ['title' => $config['seo']['create']['title']])
@include('backend.dashboard.component.formError')
@php
    $url = ($config['method'] == 'create') ? route('tag.store') : route('tag.update', $tag->id);
@endphp
<form action="{{ $url }}" method="post" class="box">
    @csrf
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-5">
                <div class="panel-head">
                    <div class="panel-title">Thông tin chung</div>
                    <div class="panel-description">
                        <p>Lưu ý: Những trường đánh dấu <span class="text-danger">(*)</span> là bắt buộc</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row mb15">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Từ khóa <span class="text-danger">(*)</span></label>
                                    <div class="title">
                                        <input 
                                            type="text"
                                            name="name"
                                            value="{{ old('name', ($tag->name) ?? '') }}"
                                            class="form-control change-title"
                                            autocomplete="off"
                                            data-flag = "{{ (isset($tag->name)) ? 1 : 0 }}"
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb15">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Đường dẫn (không bao gồm đuôi .html)  <span class="text-danger">(*)</span></label>
                                    <div class="input-wrapper">
                                        <input 
                                            type="text"
                                            name="canonical"
                                            value="{{ old('canonical', ($tag->canonical) ?? '') }}"
                                            class="form-control seo-canonical"
                                            autocomplete="off"
                                        >
                                        <span class="baseUrl">{{ config('app.url') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="text-right mb15">
            <button class="btn btn-primary" type="submit" name="send" value="send">Lưu lại</button>
        </div>
    </div>
</form>
