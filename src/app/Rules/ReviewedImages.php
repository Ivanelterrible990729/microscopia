<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ReviewedImages implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $formImages = $value;

        foreach ($formImages as $formImage) {
            if ($formImage['reviewed'] === false) {
                dump($formImage);
                $fail('Please, review all the images before confirming the wizard')->translate();
            }
        }
    }
}
