<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
            'produk' => ['required', 'max:100'],
            'harga' => ['required', 'numeric'],
            'stok' => ['required', 'numeric'],
            'berat' => ['required', 'numeric'],
            'kondisi' => ['required'],
            'thumbnail' => ['nullable'],
            'galeri' => ['nullable'],
            'deskripsi' => ['required'],
        ];
    }
}
