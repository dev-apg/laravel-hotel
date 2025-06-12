<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidateRoomsString implements ValidationRule
{

    private int $minAdults;
    private int $maxAdults;
    private int $minChildren;
    private int $maxChildren;

    public function __construct(array $adults, array $children)
    {
        $this->minAdults = $adults['min'];
        $this->maxAdults = $adults['max'];
        $this->minChildren = $children['min'];
        $this->maxChildren = $children['max'];
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        $rooms = explode('_', $value);

        if (count($rooms) < 1) {
            $fail("There was a problem with your selection");
        }

        foreach ($rooms as $roomString) {
            $pattern = '/^(\d+)-(\d+)$/';

            if (!preg_match($pattern, $roomString, $matches)) {
                $fail("There was a problem with your selection");
                return;
            }

            [, $adults, $children] = $matches;

            $adults = (int) $adults;
            $children = (int) $children;

            if ($adults < $this->minAdults || $adults > $this->maxAdults) {
                $fail("There was a problem with your selection");
                return;
            }

            if ($children < $this->minChildren || $children > $this->maxChildren) {
                $fail("There was a problem with your selection");
                return;
            }
        }
    }
}
