<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Concert;

class ConcertTest extends TestCase
{
    /** @test */
    public function can_get_formatted_date() 
    {
        $concert = factory(Concert::class)->make([
            'date' => Carbon::parse('2019-12-01 8:00pm'),
        ]);

        $this->assertEquals('December 1, 2019', $concert->formatted_date);
    }

    /** @test */
    public function can_get_formatted_start_time() 
    {
        $concert = factory(Concert::class)->make([
            'date' => Carbon::parse('2019-12-01 17:00:00'),
        ]);

        $this->assertEquals('5:00pm', $concert->formatted_start_time);
    }

    /** @test */
    public function can_get_ticket_price_in_dollars() 
    {
        $concert = factory(Concert::class)->make([
            'ticket_price' => 6739,
        ]);

        $this->assertEquals('67.39', $concert->ticket_price_in_dollars);
    }
}
