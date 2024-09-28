<?php

namespace App\Http\Requests\HomeStay;

use Illuminate\Foundation\Http\FormRequest;

class StoreHomeStayRequest extends FormRequest
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
            'name' => 'required',
            'price' => 'required',
            'open_hours' => 'gt:0',
            'total_rooms' => 'gt:0',
            'current_guests' => 'gt:0',
            'city_id' => 'gt:0',
            'color_id' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Bạn chưa nhập tiêu đề.',
            'price.required' => 'Bạn chưa nhập giá phòng.',
            'open_hours.gt' => 'Bạn chưa chọn giờ mở cửa.',
            'total_rooms.gt' => 'Bạn chưa chọn số lượng phòng.',
            'current_guests.gt' => 'Bạn chưa chọn số lượng khách.',
            'city_id.gt' => 'Bạn chưa chọn tỉnh / thành phố.',
            'color_id.required' => 'Bạn chưa chọn tình trạng',
        ];
    }
}
