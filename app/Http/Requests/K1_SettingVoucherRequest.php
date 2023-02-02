<?php

namespace App\Http\Requests;

use App\Rules\K1\Rules_cek_id_setting;
use Illuminate\Foundation\Http\FormRequest;

class K1_SettingVoucherRequest extends FormRequest
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
            'id_setting'=> ['required','integer', new Rules_cek_id_setting],
            'price_min'=> 'required','integer',
            'expired_voucher_date'=>'required','integer',
            'is_active'=>'required','integer',
            'percent_set_minimum_sell'=>'integer',
            'promo_percent'=>'integer'
        ];
    }
}
