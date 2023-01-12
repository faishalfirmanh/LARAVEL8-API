<?php

namespace App\Rules\K1;

use Illuminate\Contracts\Validation\Rule;

class Rules_cek_special_character implements Rule
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
        if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $value)) {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'gagal, inputan berisi spesial karakter';
    }
}
