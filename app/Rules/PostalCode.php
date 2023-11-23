<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PostalCode implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $value = convertPersianToEnglish($value);
        $value = convertArabicToEnglish($value);
        $pattern = "/\b(?!(\d)\1{3})[13-9]{4}[1346-9][013-9]{5}\b/";
        preg_match($pattern, $value);
    }

    public function message()
    {
        return ':attribute معتبر نمیباشد';
    }
}