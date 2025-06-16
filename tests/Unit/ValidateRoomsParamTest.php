<?php

namespace Tests\Unit;

use App\Rules\ValidateRoomsParam;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\TestWith;
use Tests\TestCase;

class MockFailException extends Exception {}

class ValidateRoomsParamTest extends TestCase
{

    use RefreshDatabase;

    private ValidateRoomsParam $sut;
    private $mockFailClosure;


    public function setUp(): void
    {
        parent::setUp();
        $this->mockFailClosure = function (string $message) {
            throw new MockFailException($message);
        };
        $this->sut = new ValidateRoomsParam(adults: ['min' => 1, 'max' => 2], children: ['min' => 0, 'max' => 2]);
    }

    #[TestWith(['1-0-single'])]
    #[TestWith(['1-0-double'])]
    #[TestWith(['1-0-accessible'])]
    #[TestWith(['2-0-double'])]
    #[TestWith(['2-0-twin'])]
    #[TestWith(['2-0-accessible'])]
    #[TestWith(['1-1-family'])]
    #[TestWith(['2-1-family'])]
    #[TestWith(['2-2-family'])]
    public function test_validation_passes(string $string)
    {
        $this->sut->validate('rooms', $string, $this->mockFailClosure);

        $this->assertTrue(true, 'Validation should pass without throwing exception');
    }

    #[TestWith(['1-1-single'])]
    #[TestWith(['1-2-single'])]
    #[TestWith(['1-1-double'])]
    #[TestWith(['1-2-double'])]
    #[TestWith(['1-1-twin'])]
    #[TestWith(['1-2-twin'])]
    #[TestWith(['1-1-accessible'])]
    #[TestWith(['1-2-accessible'])]
    public function test_validation_fails_if_no_family_room_requested_when_children_present(string $string)
    {
        $this->expectException(MockFailException::class);

        $this->sut->validate('rooms', $string, $this->mockFailClosure);
    }

    #[TestWith(['1-0-family'])]
    #[TestWith(['2-0-family'])]
    public function test_validation_fails_if_family_room_requested_when_no_children_present(string $string)
    {
        $this->expectException(MockFailException::class);

        $this->sut->validate('rooms', $string, $this->mockFailClosure);
    }

    #[TestWith(['2-0-single'])]
    public function test_validation_fails_if_two_occupants_in_single_room(string $string)
    {
        $this->expectException(MockFailException::class);

        $this->sut->validate('rooms', $string, $this->mockFailClosure);
    }

    #[TestWith(['1-0-twin'])]
    public function test_validation_fails_if_two_occupants_in_twin_room(string $string)
    {
        $this->expectException(MockFailException::class);

        $this->sut->validate('rooms', $string, $this->mockFailClosure);
    }
}
