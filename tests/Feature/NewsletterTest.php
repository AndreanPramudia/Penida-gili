<?php

namespace Tests\Feature;

use App\Models\NewsletterSubscriber;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsletterTest extends TestCase
{
    use RefreshDatabase;

    public function test_visitor_can_subscribe_once(): void
    {
        $this->from(route('home'))
            ->post(route('newsletter.store'), ['email' => 'Reader@Example.com', 'source' => 'footer'])
            ->assertRedirect(route('home').'#newsletter')
            ->assertSessionHas('newsletter');

        $this->post(route('newsletter.store'), ['email' => 'reader@example.com']);

        $this->assertDatabaseCount('newsletter_subscribers', 1);
        $this->assertSame('reader@example.com', NewsletterSubscriber::query()->sole()->email);
    }

    public function test_honeypot_blocks_bots_and_email_is_validated(): void
    {
        $this->post(route('newsletter.store'), ['email' => 'bot@example.com', 'website' => 'http://spam'])
            ->assertSessionHasErrors('website');

        $this->post(route('newsletter.store'), ['email' => 'nope'])
            ->assertSessionHasErrors('email');

        $this->assertDatabaseCount('newsletter_subscribers', 0);
    }
}
