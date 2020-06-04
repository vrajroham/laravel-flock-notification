<?php

namespace Vrajroham\LaravelFlockNotification;

use Closure;
use Vrajroham\LaravelFlockNotification\Exceptions\CouldNotSendNotification;

class FlockAttachmentView
{
    /**
     * Displays an attachment widget inside the chat screen in desktop,
     * or pops up a modal when the attachment is opened on mobile.
     *
     * @var array
     */
    public $widget;

    /**
     * Displays the HTML string inside the chat screen in desktop (using an iframe).
     *
     * @var array
     */
    public $html;

    /**
     * A string containing FlockML content. It is displayed inside the chat screen on both desktop and mobile.
     *
     * @var string
     */
    public $flockml;

    /**
     * An image for the attachment.
     *
     * @var array
     */
    public $image;

    /**
     * Create an widget.
     *
     * @param string   $src
     * @param int|null $height
     * @param int|null $width
     *
     * @return $this
     */
    public function widget($src, $height = null, $width = null)
    {
        if (!filter_var($src, FILTER_VALIDATE_URL)) {
            throw CouldNotSendNotification::flockAttachmentViewWidgetException('Source of widget in attachment is missing or invalid.');
        }
        $this->widget['src'] = $src;

        if (!filter_var($height, FILTER_VALIDATE_INT) || $height <= 0) {
            throw CouldNotSendNotification::flockAttachmentViewWidgetException('Height of widget in attachment is missing or invalid.');
        }
        $this->widget['height'] = $height;

        if (!filter_var($width, FILTER_VALIDATE_INT) || $width <= 0) {
            throw CouldNotSendNotification::flockAttachmentViewWidgetException('Width of widget in attachment is missing or invalid.');
        }
        $this->widget['width'] = $width;

        return $this;
    }

    /**
     * @param string   $inline
     * @param int|null $height
     * @param int|null $width
     *
     * @return $this
     */
    public function html($inline, $height = null, $width = null)
    {
        $this->html['inline'] = $inline;

        if (!filter_var($height, FILTER_VALIDATE_INT) || $height <= 0) {
            throw CouldNotSendNotification::flockAttachmentViewHtmlException('Height of inline html in attachment is missing or invalid.');
        }
        $this->html['height'] = $height;

        if (!filter_var($width, FILTER_VALIDATE_INT) || $width <= 0) {
            throw CouldNotSendNotification::flockAttachmentViewHtmlException('Width of inline html in attachment is missing or invalid.');
        }
        $this->html['width'] = $width;

        return $this;
    }

    /**
     * Create and FlockML sting.
     *
     * @param string $string
     *
     * @return $this
     */
    public function flockml($string)
    {
        $this->flockml = $string;

        return $this;
    }

    /**
     * Define an image for the attachment.
     *
     * @param \Closure $callback
     *
     * @return $this
     */
    public function image(Closure $callback)
    {
        $this->image = $i = new FlockAttachmentViewImage();

        $callback($i);

        return $this;
    }
}
