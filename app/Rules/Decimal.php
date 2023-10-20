<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Decimal implements Rule
{
    protected $int;
    protected $dec;
    protected $err;


    public function __construct($int, $dec)
    {
        $this->int = $int;
        $this->dec = $dec;
        $this->err = false;
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
        $pattern = "/^(([0-9]{0,".$this->int. "})(\.([0-9]{0,".$this->dec."}+))?)$/";

        if (preg_match($pattern, $value)) {
            $this->err = false;
            return true;
        } else {
            $this->err = true;
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
        if ($this->err) {
            return __('messages.MSG_ERR_007', ['int' => $this->int, 'dec' => $this->dec]);
        }
    }
}
