<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MovieFormat implements Rule
{
    private array $formats = ['dvd', 'blu-ray'];

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return in_array($value, $this->formats);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        $formats = implode(' or ', $this->formats);
        return "The format must be {$formats}.";
    }
}
