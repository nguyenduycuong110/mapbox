<?php

namespace App\Http\Requests\Code;

use Illuminate\Foundation\Http\FormRequest;

class StoreCodeRequest extends FormRequest
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
            'quantity' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'quantity.required' => 'Bạn chưa nhập số lượng mã code.',
        ];
    }
}
