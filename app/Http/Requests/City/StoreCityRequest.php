<?php

namespace App\Http\Requests\City;

use Illuminate\Foundation\Http\FormRequest;

class StoreCityRequest extends FormRequest
{
    /**
     * Determine if the Code is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|unique:cities',
            'lat' => 'required',
            'long' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Bạn chưa nhập tỉnh - thành phố.',
            'name.unique' => 'Tỉnh - thành phố đã tồn tại',
            'lat.required' => 'Bạn chưa nhập vĩ độ.',
            'long.required' => 'Bạn chưa nhập kinh độ.',
        ];
    }
}
