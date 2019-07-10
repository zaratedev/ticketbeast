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
        $this->withoutExceptionHandling();

        $concert = factory(Concert::class)->create();

        $response = $this->get(route('concerts.show', $concert->id));

        $response->assertViewIs('concerts.show');
        $response->assertSee($concert->title);
    }

    /** @test */
    public function user_cannot_view_unpublished_concert_listings()
    {
        $concert = factory(Concert::class)->create([
            'published_at' => null,
        ]);

        $response = $this->get(route('concerts.show', $concert->id));

        $response->assertStatus(404);
    }
}
