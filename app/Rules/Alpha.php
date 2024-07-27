<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Alpha implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^[\pL\s]+$/u', $value)) {
            $fail('Hướng phải là chữ');
        }
    }

    public function message()
    {
        return 'Hướng phải là chữ';
    }
}
