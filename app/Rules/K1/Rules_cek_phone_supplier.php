<?php

namespace App\Rules\K1;

use Illuminate\Contracts\Validation\Rule;

class Rules_cek_phone_supplier implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //
        if (cekPhoneNumberSupplier($value) == null) {
            return true;
        }

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'gagal, no telfon supplier sudah ada, silahkan masukkan no lain ';
    }
}
