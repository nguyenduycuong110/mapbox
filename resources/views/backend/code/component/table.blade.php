<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <th>
            <input type="checkbox" value="" id="checkAll" class="input-checkbox">
        </th>
        <th>Mã Code</th>
        <th class="text-center">Tình Trạng</th>
        <th class="text-center">Thao tác</th>
    </tr>
    </thead>
    <tbody>
        @if(isset($codes) && is_object($codes))
            @foreach($codes as $code)
            <tr >
                <td>
                    <input type="checkbox" value="{{ $code->id }}" class="input-checkbox checkBoxItem">
                </td>
                <td>
                    {{ $code->code }}
                </td>
                <td class="text-center js-switch-{{ $code->id }}"> 
                    <input type="checkbox" value="{{ $code->publish }}" class="js-switch status " data-field="publish" data-model="{{ $config['model'] }}" {{ ($code->publish == 1) ? 'checked' : '' }} data-modelId="{{ $code->id }}" />
                </td>
                <td class="text-center"> 
                    <a href="{{ route('code.delete', $code->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                </td>
            </tr>
            @endforeach
        @endif
    </tbody>
</table>
{{  $codes->links('pagination::bootstrap-4') }}
