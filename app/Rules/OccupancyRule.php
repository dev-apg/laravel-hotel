<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Log;

class OccupancyRule implements ValidationRule, DataAwareRule
{

    private int $minPerRoom;
    private int $maxPerRoom;

    /**
     * All of the data under validation.
     *
     * @var array<string, mixed>
     */
    protected $data = [];


    public function __construct(int $minPerRoom, int $maxPerRoom)
    {
        $this->minPerRoom = $minPerRoom;
        $this->maxPerRoom = $maxPerRoom;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        $roomsTotal = $this->data['rooms'];

        try {
            $array = explode(',', urldecode($value));

            // each received value should be a number within min/max occupancy params

            foreach ($array as $item) {
                if (!is_numeric($item)) {
                    $fail("$attribute does not contain valid occupancy data");
                    return;
                }

                $item = (int) $item;

                if ($item < $this->minPerRoom || $item > $this->maxPerRoom) {
                    $fail("$attribute must be between $this->minPerRoom and $this->maxPerRoom");
                    return;
                }
            }

            // the total number of received occupancy values should match the number of rooms

            if ($roomsTotal != count($array)) {
                $fail("$attribute value does not match number of rooms");
                return;
            }
        } catch (\Exception $e) {
            Log::error("Error in OccupancyRule for attribute: $attribute");
            $fail('Invalid occupancy data');
        }
    }

    /**
     * Set the data under validation.
     *
     * @param  array  $data
     * @return $this
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }
}
