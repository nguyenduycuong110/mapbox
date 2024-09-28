@if(!isset($offTitle))
    <div class="row mb15">
        <div class="col-lg-6">
            <div class="form-row">
                <label for="" class="control-label text-left">Tiêu đề <span class="text-danger">(*)</span></label>
                <div class="name">
                    <input 
                        type="text"
                        name="name"
                        value="{{ old('name', $homestay->name ?? null) }}"
                        class="form-control"
                        autocomplete="off"
                    >
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-row">
                <label for="" class="control-label text-left">Giá phòng <span class="text-danger">(*)</span></label>
                <div class="price">
                    <input 
                        type="text"
                        name="price"
                        value="{{ old('price', $homestay->price ?? null) }}"
                        class="form-control int"
                        autocomplete="off"
                    >
                </div>
            </div>
        </div>
    </div>
    <div class="row mb15">
        <div class="col-lg-6">
            <div class="form-row">
                <label for="" class="control-label text-left">Giờ mở cửa <span class="text-danger">(*)</span></label>
                <div class="open_hours">
                    @if(__('messages.open_hours'))
                        @php
                            $open_hours = request('open_hours') ?: old('open_hours');
                        @endphp
                        <div class="input-select">
                            @foreach (__('messages.open_hours') as $key => $val)
                                @if($key == 6) @break; @endif
                                <input data-value="{{ $key }}" type="text" value="{{ $val }}" class="op-hour" readonly>
                            @endforeach
                        </div>
                        <select name="open_hours" id="open_hours" class="form-control setupSelect2">
                            <option value="0">Chọn khung giờ</option>
                            @foreach (__('messages.open_hours') as $key => $val)
                                <option 
                                    value="{{ $key }}"
                                    {{ ($open_hours == $key) ? 'selected' : '' }}
                                    @if(isset($homestay))
                                        {{ $homestay->open_hours == $key ? 'selected' : '' }}
                                    @endif
                                >
                                    {{ $val }}
                                </option>
                            @endforeach
                        </select>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-row">
                <label for="" class="control-label text-left">Số lượng phòng <span class="text-danger">(*)</span></label>
                <div class="total_rooms">
                    @if(__('messages.total_rooms'))
                        @php
                            $total_rooms = request('total_rooms') ?: old('total_rooms');
                        @endphp
                        <div class="input-select">
                            @foreach (__('messages.total_rooms') as $key => $val)
                                @if($key == 11) @break; @endif
                                <input data-value="{{ $key }}" type="text" value="{{ $val }}" class="total-rooms" readonly>
                            @endforeach
                        </div>
                        <select name="total_rooms" id="total_rooms" class="form-control setupSelect2">
                            <option value="0">Chọn số lượng phòng</option>
                            @foreach (__('messages.total_rooms') as $key => $val)
                                <option 
                                    value="{{ $key }}"
                                    {{ ($total_rooms == $key) ? 'selected' : '' }}
                                    @if(isset($homestay))
                                        {{ $homestay->total_rooms == $key ? 'selected' : '' }}
                                    @endif
                                >
                                    {{ $val }}
                                </option>
                            @endforeach
                        </select>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row mb15">
        <div class="col-lg-6">
            <div class="form-row">
                <label for="" class="control-label text-left">Số lượng khách <span class="text-danger">(*)</span></label>
                <div class="current_guests">
                    @if(__('messages.current_guests'))
                        @php
                            $current_guests = request('current_guests') ?: old('current_guests');
                        @endphp
                        <div class="input-select">
                            @foreach (__('messages.current_guests') as $key => $val)
                                @if($key == 11) @break; @endif
                                <input data-value="{{ $key }}" type="text" value="{{ $val }}" class="current_guest" readonly>
                            @endforeach
                        </div>
                        <select name="current_guests" id="current_guests" class="form-control setupSelect2">
                            <option value="0">Chọn số lượng khách</option>
                            @foreach (__('messages.current_guests') as $key => $val)
                                <option 
                                    value="{{ $key }}"
                                    {{ ($current_guests == $key) ? 'selected' : '' }}
                                    @if(isset($homestay))
                                        {{ $homestay->current_guests == $key ? 'selected' : '' }}
                                    @endif
                                >
                                    {{ $val }}
                                </option>
                            @endforeach
                        </select>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-row">
                <label for="" class="control-label text-left">Địa chỉ <span class="text-danger">(*)</span></label>
                <div class="address">
                    <input 
                        type="text"
                        name="address"
                        value="{{ old('address', $homestay->address ?? null) }}"
                        class="form-control "
                        autocomplete="off"
                    >
                </div>
            </div>
        </div>
    </div>
    <div class="row mb15">
        <div class="col-lg-6">
            <div class="form-row">
                <label for="" class="control-label text-left">Vĩ độ </label>
                <div class="lat">
                    <input 
                        type="text"
                        name="lat"
                        value="{{ old('lat', $homestay->lat ?? null) }}"
                        class="form-control"
                        autocomplete="off"
                    >
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-row">
                <label for="" class="control-label text-left">Kinh độ</label>
                <div class="long">
                    <input 
                        type="text"
                        name="long"
                        value="{{ old('long', $homestay->long ?? null) }}"
                        class="form-control"
                        autocomplete="off"
                    >
                </div>
            </div>
        </div>
    </div>
@endif
