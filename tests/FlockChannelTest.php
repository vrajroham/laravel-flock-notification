<?php

namespace Vrajroham\LaravelFlockNotification\Tests;

use Mockery;
use PHPUnit\Framework\TestCase;
use Vrajroham\LaravelFlockNotification\Flock;
use Illuminate\Notifications\Notification;
use Vrajroham\LaravelFlockNotification\FlockChannel;
use Vrajroham\LaravelFlockNotification\FlockMessage;
use Vrajroham\LaravelFlockNotification\Exceptions\CouldNotSendNotification;

class FlockChannelTest extends TestCase
{
    /** @var Mockery\Mock */
    protected $flock;

    /** @var \NotificationChannels\Flock\FlockChannel */
    protected $channel;

    public function setUp()
    {
        parent::setUp();
        $this->flock = Mockery::mock(Flock::class);
        $this->channel = new FlockChannel($this->flock);
    }

    /** @test */
    public function it_can_send_a_message()
    {
        $this->flock->shouldReceive('sendMessage')->with('url', [
                'text' => 'Laravel Notification Channel for flock!',
        ]);
        $this->channel->send(new TestNotifiable(), new TestNotification());
    }

    /** @test */
    public function it_throws_an_exception_when_it_could_not_send_the_notification_because_no_chat_id_provided()
    {
        $this->expectException(CouldNotSendNotification::class);
        $this->channel->send(new TestNotifiableWithoutFlockRoute(), new TestNotification());
    }
}

class TestNotifiable
{
    use \Illuminate\Notifications\Notifiable;

    /**
     * @return string
     */
    public function routeNotificationForFlock()
    {
        return 'url';
    }
}

class TestNotifiableWithoutFlockRoute
{
    use \Illuminate\Notifications\Notifiable;
}

class TestNotification extends Notification
{
    public function toFlock($notifiable)
    {
        return FlockMessage::create('Laravel Notification Channel for flock!');
    }
}
