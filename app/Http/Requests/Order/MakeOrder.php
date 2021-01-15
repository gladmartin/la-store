<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class MakeOrder extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'kuantitas' => ['required', 'numeric'],
            'product_id' => ['required', 'exists:App\Models\Product,id'],
            'provinsi' => ['required', 'exists:App\Models\Province,province_id'],
            'kota' => ['required', 'exists:App\Models\City,city_id'],
            'kecamatan' => ['required'],
            'no_wa' => ['required', 'numeric', 'min:11'],
            'nama' => ['required'],
            'email' => ['required', 'email'],
            'alamat' => ['required'],
            'variants' => ['nullable'],
            'ekspedisi' => ['required'],
            'service' => ['required'],
            'ongkos_kirim' => ['required'],
        ];
    }
}
