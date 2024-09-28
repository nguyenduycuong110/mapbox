<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <th>
            <input type="checkbox" value="" id="checkAll" class="input-checkbox">
        </th>
        <th>Màu</th>
        <th class="text-center">Mã màu</th>
        <th class="text-center">Ghi chú</th>
        <th class="text-center">Tình Trạng</th>
        <th class="text-center">Thao tác</th>
    </tr>
    </thead>
    <tbody>
        @if(isset($colors) && is_object($colors))
            @foreach($colors as $color)
            <tr >
                <td>
                    <input type="checkbox" value="{{ $color->id }}" class="input-checkbox checkBoxItem">
                </td>
                <td>
                    {{ $color->name }}
                </td>
                <td class="text-center">
                    {{ $color->code }}
                </td>
                <td class="text-center">
                    {{ $color->description }}
                </td>
                <td class="text-center js-switch-{{ $color->id }}"> 
                    <input type="checkbox" value="{{ $color->publish }}" class="js-switch status " data-field="publish" data-model="{{ $config['model'] }}" {{ ($color->publish == 1) ? 'checked' : '' }} data-modelId="{{ $color->id }}" />
                </td>
                <td class="text-center"> 
                    <a href="{{ route('color.edit', $color->id) }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                    <a href="{{ route('color.delete', $color->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                </td>
            </tr>
            @endforeach
        @endif
    </tbody>
</table>
{{  $colors->links('pagination::bootstrap-4') }}
