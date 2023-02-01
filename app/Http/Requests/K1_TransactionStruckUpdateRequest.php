<?php

namespace App\Http\Requests;

use App\Rules\K1\Rules_cek_code_trans_in_struckForUpdate;
use App\Rules\K1\Rules_cek_voucher;
use App\Rules\K1\Rules_cek_voucher_isUsed;
use Illuminate\Foundation\Http\FormRequest;

class K1_TransactionStruckUpdateRequest extends FormRequest
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
            'kode_transaction' => ['required', new Rules_cek_code_trans_in_struckForUpdate],
            'money_from_user'=> ['integer','required'],
            'voucher'=> [new Rules_cek_voucher]
        ];
    }
}
