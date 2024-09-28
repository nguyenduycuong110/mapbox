<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <th>
            <input type="checkbox" value="" id="checkAll" class="input-checkbox">
        </th>
        <th>Thành phố</th>
        <th class="text-center">Vĩ độ</th>
        <th class="text-center">Kinh độ</th>
        <th class="text-center">Tình Trạng</th>
        <th class="text-center">Thao tác</th>
    </tr>
    </thead>
    <tbody>
        @if(isset($cities) && is_object($cities))
            @foreach($cities as $city)
            <tr >
                <td>
                    <input type="checkbox" value="{{ $city->id }}" class="input-checkbox checkBoxItem">
                </td>
                <td>
                    {{ $city->name }}
                </td>
                <td class="text-center">
                    {{ $city->lat }}
                </td>
                <td class="text-center">
                    {{ $city->long }}
                </td>
                <td class="text-center js-switch-{{ $city->id }}"> 
                    <input type="checkbox" value="{{ $city->publish }}" class="js-switch status " data-field="publish" data-model="{{ $config['model'] }}" {{ ($city->publish == 1) ? 'checked' : '' }} data-modelId="{{ $city->id }}" />
                </td>
                <td class="text-center"> 
                    <a href="{{ route('city.edit', $city->id) }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                    <a href="{{ route('city.delete', $city->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                </td>
            </tr>
            @endforeach
        @endif
    </tbody>
</table>
{{  $cities->links('pagination::bootstrap-4') }}
