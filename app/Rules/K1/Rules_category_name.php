<?php

namespace App\Rules\K1;

use Illuminate\Contracts\Validation\Rule;

class Rules_category_name implements Rule
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
        if(cekCategoryName($value) == null){
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
        return 'gagal, nama cateogry harus unik, nama ini sudah ada, tolong masukkan nama lain';
    }
}
