<?php

namespace Tests\Feature;

use App\Models\Link;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LinkShortenerTest extends TestCase
{
    use RefreshDatabase;

    public function test_redirect_sends_visitor_to_original_url(): void
    {
        $link = Link::factory()->create([
            'original_url' => 'https://example.com/some-page',
            'short_code' => 'abc123',
        ]);

        $response = $this->get('/abc123');

        $response->assertRedirect('https://example.com/some-page');
    }
    
    public function test_visiting_short_link_records_a_click(): void
    {
        $link = Link::factory()->create(['short_code' => 'abc123']);

        $this->get('/abc123');

        $this->assertDatabaseCount('clicks', 1);
        $this->assertDatabaseHas('clicks', ['link_id' => $link->id]);
    }

    public function test_visiting_unknown_short_code_returns_404(): void
    {
        $this->get('/doesnotexist')->assertNotFound();
    }

    public function test_repeated_visits_are_all_recorded(): void
    {
        $link = Link::factory()->create(['short_code' => 'abc123']);

        $this->get('/abc123');
        $this->get('/abc123');
        $this->get('/abc123');

        $this->assertDatabaseCount('clicks', 3);
    }

    public function test_guest_cannot_access_dashboard(): void
    {
        $this->get('/dashboard/links')->assertRedirect('/dashboard/login');
    }
}
