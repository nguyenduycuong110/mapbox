@include('backend.dashboard.component.breadcrumb', ['title' => $config['seo']['create']['title']])
@include('backend.dashboard.component.formError')
@php
    $url = ($config['method'] == 'create') ? route('city.store') : route('city.update', $city->id);
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
                                    <label for="" class="control-label text-left">Tỉnh / thành phố <span class="text-danger">(*)</span></label>
                                    <div class="name">
                                        <input 
                                            type="text"
                                            name="name"
                                            value="{{ old('name', $city->name ?? null) }}"
                                            class="form-control"
                                            autocomplete="off"
                                        >
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Số điện thoại<span class="text-danger">(*)</span></label>
                                    <div class="phone">
                                        <input 
                                            type="text"
                                            name="phone"
                                            value="{{ old('phone', $city->phone ?? null) }}"
                                            class="form-control"
                                            autocomplete="off"
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Vĩ độ <span class="text-danger">(*)</span></label>
                                    <div class="lat">
                                        <input 
                                            type="text"
                                            name="lat"
                                            value="{{ old('lat', $city->lat ?? null) }}"
                                            class="form-control"
                                            autocomplete="off"
                                        >
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Kinh độ <span class="text-danger">(*)</span></label>
                                    <div class="long">
                                        <input 
                                            type="text"
                                            name="long"
                                            value="{{ old('long', $city->long ?? null) }}"
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
