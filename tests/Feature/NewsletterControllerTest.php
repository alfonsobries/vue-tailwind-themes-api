<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Mailcoach\Models\EmailList;
use Spatie\Mailcoach\Models\Subscriber;
use Tests\TestCase;

class NewsletterControllerTest extends TestCase
{
    /** @test **/
    public function a_guest_user_can_subscribe_to_the_newsletter()
    {
        $emailList = EmailList::firstOrCreate([
            'name' => 'newsletter',
            'requires_confirmation' => true,
        ]);

        $this
            ->post(
                route('newsletter.subscribe'),
                ['email' => 'john@example.com']
            )
            ->assertSuccessful();

        $this->assertNotNull($emailList->allSubscribers->where('email', 'john@example.com')->first());
        $this->assertDatabaseHas('mailcoach_subscribers', ['email' => 'john@example.com']);
    }

    /** @test **/
    public function when_a_user_subscribes_to_the_newsletter_the_subscriber_status_is_unconfirmed()
    {
        EmailList::firstOrCreate([
            'name' => 'newsletter',
            'requires_confirmation' => true,
        ]);

        $this
            ->post(
                route('newsletter.subscribe'),
                ['email' => 'john@example.com']
            )
            ->assertSuccessful();

        $subscriber = Subscriber::where('email', 'john@example.com')->first();

        $this->assertEquals('unconfirmed', $subscriber->status);
    }

    /** @test **/
    public function a_user_can_unsubscribe_from_the_newsletter_list()
    {
        $emailList = EmailList::firstOrCreate([
            'name' => 'newsletter',
            'requires_confirmation' => true,
        ]);

        $emailList->subscribeskippingConfirmation('john@example.com');

        $this
            ->post(
                route('newsletter.unsubscribe'),
                ['email' => 'john@example.com']
            )
            ->assertSuccessful();

        $subscriber = Subscriber::where('email', 'john@example.com')->first();

        $this->assertEquals('unsubscribed', $subscriber->status);
    }
}
