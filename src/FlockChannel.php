<?php

namespace Vrajroham\LaravelFlockNotification;

use Illuminate\Notifications\Notification;
use Vrajroham\LaravelFlockNotification\Exceptions\CouldNotSendNotification;

class FlockChannel
{
    /**
     * Flock instance.
     *
     * @var Flock
     */
    protected $flock;

    /**
     * FlockChannel constructor.
     *
     * @param Flock $flock
     */
    public function __construct(Flock $flock)
    {
        $this->flock = $flock;
    }

    /**
     * Send the given notification.
     *
     * @param mixed                                  $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @throws \NotificationChannels\Flock\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toFlock($notifiable);

        if (is_string($message)) {
            $message = FlockMessage::create($message);
        }

        if (!$notifiable->routeNotificationFor('flock')) {
            throw CouldNotSendNotification::flockRouteNotProvided();
        }

        $url = $notifiable->routeNotificationFor('flock');
        $params = $message->toArray();

        $this->flock->sendMessage($url, $params);
    }
}
