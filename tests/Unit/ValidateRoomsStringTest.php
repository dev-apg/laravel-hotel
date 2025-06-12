<?php

namespace Tests\Unit;

use App\Rules\ValidateRoomsString;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MockFailException extends Exception {}

class ValidateRoomsStringTest extends TestCase
{

    use RefreshDatabase;

    private ValidateRoomsString $sut;
    private $mockFailClosure;

    public function setUp(): void
    {
        parent::setUp();
        $this->mockFailClosure = function (string $message) {
            throw new MockFailException($message);
        };
        $this->sut = new ValidateRoomsString(adults: ['min' => 1, 'max' => 2], children: ['min' => 0, 'max' => 1]);
    }

    public function test_validation_passes_with_min_occupancy()
    {

        $this->sut->validate('rooms', '1-0', $this->mockFailClosure);

        $this->assertTrue(true, 'Validation should pass without throwing exception');
    }

    public function test_validation_passes_with_max_occupancy()
    {

        $this->sut->validate('rooms', '2-1', $this->mockFailClosure);

        $this->assertTrue(true, 'Validation should pass without throwing exception');
    }

    public function test_validation_passes_with_two_rooms_min_occupancy()
    {

        $this->sut->validate('rooms', '1-0_1-0', $this->mockFailClosure);

        $this->assertTrue(true, 'Validation should pass without throwing exception');
    }

    // public function test_validation_fails_if_too_few_rooms()
    // {
    //     $this->expectException(MockFailException::class);

    //     $this->sut->validate('adults', urlencode("1"), $this->mockFailClosure);
    // }

    // public function test_validation_fails_if_too_many_rooms()
    // {
    //     $this->expectException(MockFailException::class);

    //     $this->sut->validate('adults', urlencode("1"), $this->mockFailClosure);
    // }

    // public function test_validation_fails_if_occupancy_below_min()
    // {
    //     $this->expectException(MockFailException::class);

    //     $this->sut->validate('adults', urlencode("0,1"), $this->mockFailClosure);
    // }

    // public function test_validation_fails_if_occupancy_exceeds_max()
    // {
    //     $this->expectException(MockFailException::class);

    //     $this->sut->validate('adults', urlencode("2,3"), $this->mockFailClosure);
    // }

    // public function test_validation_fails_if_occupancy_not_numeric()
    // {
    //     $this->expectException(MockFailException::class);

    //     $this->sut->validate('adults', urlencode("adfd,3"), $this->mockFailClosure);
    // }
}
