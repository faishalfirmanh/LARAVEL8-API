<?php

namespace App\Rules\K1;

use Illuminate\Contracts\Validation\Rule;

class Rules_cek_productId implements Rule
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
        if (getProductById($value) != null) {
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
        return 'Gagal, product_id tidak ditemukan';
    }
}
