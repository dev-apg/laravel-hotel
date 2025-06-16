<?php

namespace App\Rules;

use App\Enums\RoomType;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidateRoomsParam implements ValidationRule
{

    private int $minAdults;
    private int $maxAdults;
    private int $minChildren;
    private int $maxChildren;

    private array $familyRoomTypes = [RoomType::FAMILY->value];
    private array $singleRoomTypes = [RoomType::SINGLE->value, RoomType::DOUBLE->value, RoomType::ACCESSIBLE->value];
    private array $dualRoomTypes = [RoomType::DOUBLE->value, RoomType::TWIN->value, RoomType::ACCESSIBLE->value];

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
            $pattern = '/^(\d+)-(\d+)-(\w+)$/';

            if (!preg_match($pattern, $roomString, $matches)) {
                $fail("There was a problem with your selection - first bit");
                return;
            }

            [, $adults, $children, $type] = $matches;

            $adults = (int) $adults;
            $children = (int) $children;

            $error = false;

            if ($adults < $this->minAdults || $adults > $this->maxAdults) {
                $error = true;
            }

            if ($children < $this->minChildren || $children > $this->maxChildren) {
                $error = true;
            }

            if ((int)$children > 0) {
                if (!in_array($type, $this->familyRoomTypes)) {
                    $error = true;
                }
            } else if ($adults == 1) {
                if (!in_array($type, $this->singleRoomTypes)) {
                    $error = true;
                }
            } else if ($adults == 2) {
                if (!in_array($type, $this->dualRoomTypes)) {
                    $error = true;
                }
            } else {
                $error = true;
            }

            if ($error) {
                $fail("There was a problem with your selection");
            }
        }
    }
}
