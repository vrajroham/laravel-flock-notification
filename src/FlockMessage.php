<?php

namespace Vrajroham\LaravelFlockNotification;

use Closure;
use NotificationChannels\LaravelFlockNotification\Exceptions\CouldNotSendNotification;

class FlockMessage
{
    /**
     * @var array Parameters payload
     */
    public $payload = [];

    /**
     * @param string $content
     *
     * @return static
     */
    public static function create($content = '')
    {
        return new static($content);
    }

    /**
     * Message constructor.
     *
     * @param string $content
     */
    public function __construct($content = '')
    {
        $this->content($content);
    }

    /**
     * Notification message.
     *
     * @param string $content
     *
     * @return $this
     */
    public function content($content)
    {
        $this->payload['text'] = $content;

        return $this;
    }

    /**
     * Message body as FlockML.
     *
     * @param string $content
     *
     * @return $this
     */
    public function flockml($content)
    {
        $this->payload['flockml'] = $content;

        return $this;
    }

    /**
     * Text to be shown as the message's notification. (Default is text.).
     *
     * @param string $notification
     *
     * @return $this
     */
    public function notification($notification)
    {
        $this->payload['notification'] = $notification;

        return $this;
    }

    /**
     * This field is used this if the sender would want to display
     * another name and image as the sender.
     *
     * @param string $name
     * @param string $profileImage
     *
     * @return $this
     */
    public function sendAs($name, $profileImage = null)
    {
        if (!is_string($name)) {
            throw CouldNotSendNotification::flockMessageException('Name should be string in sendAs field');
        }

        if ($profileImage === null) {
            throw CouldNotSendNotification::flockMessageException('Profile image URL in sendAs field');
        }

        if (!filter_var($profileImage, FILTER_VALIDATE_URL)) {
            throw CouldNotSendNotification::flockMessageException('Profile image URL is invalid');
        }

        $this->payload['sendAs']['name'] = $name;
        $this->payload['sendAs']['profileImage'] = $profileImage;

        return $this;
    }

    /**
     * Returns params payload.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->payload;
    }

    /**
     * Define an attachment for the message.
     *
     * @param \Closure $callback
     *
     * @return $this
     */
    public function attachments(Closure $callback)
    {
        $this->payload['attachments'][] = $attachment = new FlockAttachment();

        $callback($attachment);

        return $this;
    }
}
