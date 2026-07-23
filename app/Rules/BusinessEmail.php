<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class BusinessEmail implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $value = \Illuminate\Support\Str::of($value)->trim()->squish()->lower()->toString();

        $domain = \Illuminate\Support\Str::of($value)->after('@')->toString();

        if (!in_array($domain, ['company.com', 'business.com'])) {
            $fail("The :attribute must be a business email.");
        }
    }
}
