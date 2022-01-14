<?php

namespace App\Http\Requests\BlackList;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlackListRequest extends FormRequest
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
            'blacklist' => ['required'],
        ];
    }
}
