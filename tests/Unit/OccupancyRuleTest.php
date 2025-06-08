<?php

namespace Tests\Unit;

use App\Rules\OccupancyRule;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MockFailException extends Exception {}

class OccupancyRuleTest extends TestCase
{

    use RefreshDatabase;

    private OccupancyRule $sut;
    private $mockFailClosure;

    public function setUp(): void
    {
        parent::setUp();
        $this->mockFailClosure = function (string $message) {
            throw new MockFailException($message);
        };
        $this->sut = new OccupancyRule(minPerRoom: 1, maxPerRoom: 2);
        $this->sut->setData(['rooms' => 2]);
    }

    public function test_validation_passes_with_min_occupancy()
    {

        $this->sut->validate('adults', urlencode("1,1"), $this->mockFailClosure);

        $this->assertTrue(true, 'Validation should pass without throwing exception');
    }

    public function test_validation_passes_with_max_occupancy()
    {

        $this->sut->validate('adults', urlencode("2,2"), $this->mockFailClosure);

        $this->assertTrue(true, 'Validation should pass without throwing exception');
    }

    public function test_validation_fails_if_too_few_rooms()
    {
        $this->expectException(MockFailException::class);

        $this->sut->validate('adults', urlencode("1"), $this->mockFailClosure);
    }

    public function test_validation_fails_if_too_many_rooms()
    {
        $this->expectException(MockFailException::class);

        $this->sut->validate('adults', urlencode("1"), $this->mockFailClosure);
    }

    public function test_validation_fails_if_occupancy_below_min()
    {
        $this->expectException(MockFailException::class);

        $this->sut->validate('adults', urlencode("0,1"), $this->mockFailClosure);
    }

    public function test_validation_fails_if_occupancy_exceeds_max()
    {
        $this->expectException(MockFailException::class);

        $this->sut->validate('adults', urlencode("2,3"), $this->mockFailClosure);
    }

    public function test_validation_fails_if_occupancy_not_numeric()
    {
        $this->expectException(MockFailException::class);

        $this->sut->validate('adults', urlencode("adfd,3"), $this->mockFailClosure);
    }
}
