@include('backend.dashboard.component.breadcrumb', ['title' => $config['seo']['create']['title']])
@include('backend.dashboard.component.formError')
@php
    $url = ($config['method'] == 'create') ? route('color.store') : route('color.update', $color->id);
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
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Màu <span class="text-danger">(*)</span></label>
                                    <div class="name">
                                        <input 
                                            type="text"
                                            name="name"
                                            value="{{ old('name', $color->name ?? null) }}"
                                            class="form-control"
                                            autocomplete="off"
                                        >
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Mã màu <span class="text-danger">(*)</span></label>
                                    <div class="code">
                                        <input 
                                            type="text"
                                            name="code"
                                            value="{{ old('code', $color->code ?? null) }}"
                                            class="form-control"
                                            autocomplete="off"
                                        >
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Ghi chú </label>
                                    <div class="description">
                                        <input 
                                            type="text"
                                            name="description"
                                            value="{{ old('description', $color->description ?? null) }}"
                                            class="form-control"
                                            autocomplete="off"
                                        >
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
