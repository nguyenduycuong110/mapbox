
<div class="ibox w">
    <div class="ibox-title">
        <h5>{{ __('messages.image') }}</h5>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="form-row">
                    <span class="image img-cover image-target"><img src="{{ (old('image', ($homestay->image) ?? '' ) ? old('image', ($homestay->image) ?? '')   :  'backend/img/not-found.jpg') }}" alt=""></span>
                    <input type="hidden" name="image" value="{{ old('image', ($homestay->image) ?? '' ) }}">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="ibox w">
    <div class="ibox-title">
        <h5>Chọn tỉnh / thành phố</h5>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="form-row">
                    <div class="mb15">
                        <select name="city_id" class="form-control setupSelect2">
                            <option value="0">[Chọn Tỉnh / Thành phố]</option>
                            @foreach($cities as $key => $item)
                                <option 
                                    {{ 
                                        $item->id == old('city_id', (isset($homestay->city_id)) ? $homestay->city_id : '') ? 'selected' : '' 
                                    }}  
                                    value="{{ $item->id }}"
                                >
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="ibox w">
    <div class="ibox-title">
        <h5>Chọn tình trạng</h5>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="form-row color-box">
                    @foreach($colors as $key => $val)
                        <div class="wizard-form-checkbox">
                            <input 
                                id="{{ $val['id'] }}"
                                name="color_id" 
                                type="checkbox" 
                                value="{{ $val['id'] }}"
                                {{ (old('color_id') == $val['id']) ? 'checked' : '' }} 
                                @if(isset($homestay))
                                    {{ $homestay->color_id  == $val['id'] ? 'checked' : '' }} 
                                @endif
                            >
                            <label 
                                data-id="{{ $val['id'] }}"
                                for="{{ $val['id'] }}"  
                                class="color {{ (old('color_id') == $val['id']) ? 'active' : '' }} 
                                {{ isset($homestay) && $homestay->color_id == $val['id'] ? 'active' : '' }}" 
                                style="background: {{ $val['code'] }}"
                            >
                                {{ $val['description'] }}
                            </label>
                        </div>
                    
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>