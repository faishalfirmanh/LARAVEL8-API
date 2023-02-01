<?php

namespace App\Http\Requests;

use App\Rules\K1\Rules_cek_code_trans_in_details;
use App\Rules\K1\Rules_cek_code_trans_in_struckForPost;
use App\Rules\K1\Rules_cek_generate_code;
use Illuminate\Foundation\Http\FormRequest;

class K1_TransactionBeforePrintRequest extends FormRequest
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
            'amount'=> 'integer',
            'kode_transaction'=> ['required', new Rules_cek_generate_code, 
                                new Rules_cek_code_trans_in_details,
                                new Rules_cek_code_trans_in_struckForPost],
            'money_from_user'=> 'integer',
        ];
    }
}
