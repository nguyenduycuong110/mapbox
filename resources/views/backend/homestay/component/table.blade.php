<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <th>
            <input type="checkbox" value="" id="checkAll" class="input-checkbox">
        </th>
        <th >Tiêu đề</th>
        <th class="text-center">Giá</th>
        <th class="text-center">Giờ mở cửa</th>
        <th class="text-center">Số phòng</th>
        <th class="text-center">Số khách</th>
        <th class="text-center">Thành phố</th>
        <th class="text-center">Tình Trạng</th>
        <th class="text-center">Thao tác</th>
    </tr>
    </thead>
    <tbody>
        @if(isset($homeStays) && is_object($homeStays))
            @foreach($homeStays as $homestay)
                <tr >
                    <td>
                        <input type="checkbox" value="{{ $homestay->id }}" class="input-checkbox checkBoxItem">
                    </td>
                    <td >
                        {{ $homestay->name }}
                        <div class="info mt10">
                            <p>Địa chỉ : {{ $homestay->address }}</p>
                            <p>Vĩ độ : {{ $homestay->lat }}</p>
                            <p>Kinh độ : {{ $homestay->long }}</p>
                        </div>
                    </td>
                    <td class="text-center">
                        <span class="int">{{ number_format($homestay->price , 0, ',', '.') }}</span>
                    </td>
                    <td class="text-center">
                        <span class="text-danger">{{ __('messages.open_hours')[$homestay->open_hours] }}</span>
                    </td>
                    <td class="text-center">
                        {{ __('messages.total_rooms')[$homestay->total_rooms] }}
                    </td>
                    <td class="text-center">
                        {{ __('messages.current_guests')[$homestay->current_guests] }}
                    </td>
                    <td class="text-center">
                        {{ $homestay->cities->name }}
                    </td>
                    <td class="text-center">
                        <span style="background: {{ $homestay->colors->code }}" class="tb-color">
                            {{ $homestay->colors->description }}
                        </span>
                    </td>
                    <td class="text-center"> 
                        <a href="{{ route('homestay.edit', $homestay->id) }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                        <a href="{{ route('homestay.delete', $homestay->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
{{  $homeStays->links('pagination::bootstrap-4') }}
