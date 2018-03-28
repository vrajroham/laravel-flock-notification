<?php

namespace Vrajroham\LaravelFlockNotification\Tests;

use PHPUnit\Framework\TestCase;
use Vrajroham\LaravelFlockNotification\FlockMessage;

class FlockMessageTest extends TestCase
{
    /** @test */
    public function it_accepts_text_contents_when_constructed()
    {
        $message = new FlockMessage('Laravel notification channel for flock.');
        $this->assertEquals('Laravel notification channel for flock.', $message->payload['text']);
    }

    /** @test */
    public function the_notification_content_can_be_set()
    {
        $message = new FlockMessage();
        $message->content('Laravel notification channel for flock.');
        $this->assertEquals('Laravel notification channel for flock.', $message->payload['text']);
    }

    /** @test */
    public function it_can_return_payload_as_array()
    {
        $message = new FlockMessage('Laravel notification channel for flock.');

        $this->assertEquals([
            'text' => 'Laravel notification channel for flock.',
        ], $message->toArray());
    }
}
