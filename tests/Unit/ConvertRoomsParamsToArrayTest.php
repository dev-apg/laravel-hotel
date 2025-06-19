<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Hotel;
use App\Http\Services\ConvertRoomsParamToArray;
use App\Models\Extra;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ConvertRoomsParamsToArrayTest extends TestCase
{

    use RefreshDatabase;

    private ConvertRoomsParamToArray $sut;

    public function setUp(): void
    {
        parent::setUp();
        $this->sut = new ConvertRoomsParamToArray();
    }

    public function test_param_is_converted_to_array()
    {

        $hotel = Hotel::factory()->create(['name' => 'Test Hotellll']);

        $breakfast = Extra::factory()->create(['name' => 'breakfast', 'description' => 'Breakfast included', 'pricing_type' => 'per_person_per_day']);
        $wifi = Extra::factory()->create(['name' => 'wifi', 'description' => 'High-speed internet access', 'pricing_type' => 'per_stay']);

        $hotel->extras()->attach([
            $breakfast->id => ['price' => 1500],
            $wifi->id => ['price' => 500]
        ]);

        $input = [
            'hotel_id' => 1,
            'from' => '2024-01-01',
            'to' => '2024-01-05',
            'rooms' => '2-1-family_1-0-single'
        ];

        $result = $this->sut->toArray($input);

        $this->assertTrue(true);

        $this->assertEquals(1, $result['hotel_id']);
        $this->assertEquals('Test Hotellll', $result['hotel']);
        $this->assertEquals('2024-01-01', $result['from']);
        $this->assertEquals('2024-01-05', $result['to']);

        // $extraNames = $result['extras']->pluck('name')->toArray();
        // $this->assertEquals(['breakfast', 'wifi'], $extraNames);

        $this->assertCount(2, $result['rooms']);

        $this->assertEquals(['adults' => '2', 'children' => '1', 'type' => 'family', 'available_extras' => $hotel->extras->toArray(), 'selected_extras' => []], $result['rooms'][0]);
        // $this->assertEquals(['adults' => '1', 'children' => '0', 'type' => 'single'], $result['rooms'][1]);
    }
}
