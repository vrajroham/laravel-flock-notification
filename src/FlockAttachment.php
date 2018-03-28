<?php

namespace Vrajroham\LaravelFlockNotification;

use Closure;
use Vrajroham\LaravelFlockNotification\Exceptions\CouldNotSendNotification;

class FlockAttachment
{
    /**
     * A unique identifier for the attachment as provided by your app.
     *
     * @var string | null
     */
    public $id;

    /**
     * The title of the attachment.
     *
     * @var string
     */
    public $title;

    /**
     * A longer description of the attachment.
     *
     * @var string
     */
    public $description;

    /**
     * App id for the app that sent the attachment. Any value that your app provides for this attribute
     * will be overwritten with your app's actual id by Flock.
     *
     * @var string
     */
    public $appId;

    /**
     * A hex value (e.g. "#0ABE51") for the color bar.
     *
     * @var string
     */
    public $color;

    /**
     * Provides user visible views for the attachment. See below for more details.
     *
     * @var views
     */
    public $views;

    /**
     * The URL to open when user clicks an attachment, if no widget or FlockML is provided.
     * When generating a URL Preview this should always be set.
     *
     * @var string
     */
    public $url;

    /**
     * If true, the attachment can be forwarded. Default value is false.
     *
     * @var bool
     */
    public $forward = false;

    /**
     * An array of download objects. Note: As of now this array should contain at max one object.
     *
     * @var array
     */
    public $downloads;

    /**
     * An array of attachment buttons.
     *
     * @var array
     */
    public $buttons;

    /**
     * Set the id of attachment.
     *
     * @param   string  $id
     *
     * @return $this
     */
    public function id($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set title of attachment.
     *
     * @param string $title
     *
     * @return $this
     */
    public function title($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Set description of attachment.
     * @param string $description
     *
     * @return $this
     */
    public function description($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Set application id for attachment.
     *
     * @param string $appId
     *
     * @return $this
     */
    public function appId($appId)
    {
        $this->appId = $appId;

        return $this;
    }

    /**
     * Set color of attachment.
     *
     * @param string $color
     *
     * @return $this
     */
    public function color($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Set forward option. Default false.
     *
     * @param bool $forward
     *
     * @return $this
     */
    public function forward($forward)
    {
        if (! is_bool($forward)) {
            throw CouldNotSendNotification::flockAttachmentForwardException('Forward field should be boolean.');
        }
        $this->forward = $forward;

        return $this;
    }

    /**
     * Set url for preview.
     *
     * @param string $url
     *
     * @return $this
     */
    public function url($url)
    {
        if (! filter_var($url, FILTER_VALIDATE_URL)) {
            throw CouldNotSendNotification::flockAttachmentUrlException('Invalid URL in attachment');
        }
        $this->url = $url;

        return $this;
    }

    /**
     * Define an view for the attachment.
     *
     * @param  \Closure  $callback
     * @return $this
     */
    public function views(Closure $callback)
    {
        $this->views = $view = new FlockAttachmentView;

        $callback($view);

        return $this;
    }

    /**
     * Define an downloads for the attachment.
     *
     * @param  array $files
     * @return $this
     */
    public function downloads($files)
    {
        foreach ($files as $key => $file) {
            if (! filter_var($file['src'], FILTER_VALIDATE_URL)) {
                throw CouldNotSendNotification::flockAttachmentDownloadException('Invalid source for attachment download.');
            }

            $this->downloads[] = $file;
        }

        return $this;
    }

    /**
     * Define an buttons for the attachment.
     *
     * @param  array    $buttons
     * @return $this
     */
    public function buttons($buttons)
    {
        foreach ($buttons as $key => $button) {
            if (! filter_var($button['icon'], FILTER_VALIDATE_URL)) {
                throw CouldNotSendNotification::flockAttachmentButtonException('Invalid Icon URL for attachment button.');
            }

            if (! isset($button['action']) || ! is_array($button['action'])) {
                throw CouldNotSendNotification::flockAttachmentButtonException('Attachment button action is required and needs to be an array');
            }

            if (! isset($button['action']['url']) || ! filter_var($button['action']['url'], FILTER_VALIDATE_URL)) {
                throw CouldNotSendNotification::flockAttachmentButtonException('Attachment button action url is invalid or missing.');
            }

            $this->buttons[] = $button;
        }

        return $this;
    }
}
