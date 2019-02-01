<?php

namespace Tests\Feature;

use App\Models\Concert;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewConcertListingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_a_concert_listing()
    {
        // Create a concert
        $concert = factory(Concert::class)->create();

        // Act
        $response = $this->get(route('concerts.show', $concert));

        // Assertions
        $response->assertViewIs('concerts.show');
        $response->assertSee($concert->title);
    }
}
