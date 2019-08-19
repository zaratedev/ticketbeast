<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Concert;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewConcertListingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_a_published_concert_listing()
    {
        $this->withoutExceptionHandling();

        $concert = factory(Concert::class)->states('published')->create();

        $response = $this->get(route('concerts.show', $concert->id));

        $response->assertViewIs('concerts.show');
        $response->assertSee($concert->title);
    }

    /** @test */
    public function user_cannot_view_unpublished_concert_listings()
    {
        $concert = factory(Concert::class)->states('unpublished')->create();

        $response = $this->get(route('concerts.show', $concert->id));

        $response->assertStatus(404);
    }
}
