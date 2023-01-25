<?php

namespace App\Http\Requests;

use App\Rules\K1\Rules_cek_generate_code;
use App\Rules\K1\Rules_cek_productId;
use App\Rules\K1\Rules_cek_userId;
use Illuminate\Foundation\Http\FormRequest;

class K1_TransRequest extends FormRequest
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
            'id_user' => ['required','integer', new Rules_cek_userId],
            'id_product' => ['required','integer',new Rules_cek_productId],
            'total_product'=> ['required', 'integer'],
            'kode_transaction'=>['required', new Rules_cek_generate_code]
        ];
    }
}
