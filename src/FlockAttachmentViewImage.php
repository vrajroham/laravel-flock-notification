<?php

namespace Vrajroham\LaravelFlockNotification;

use Vrajroham\LaravelFlockNotification\Exceptions\CouldNotSendNotification;

class FlockAttachmentViewImage
{
    /**
     * Image object.
     *
     * @var array
     */
    public $original;

    /**
     * Thumbnail object.
     *
     * @var array
     */
    public $thumbnail;

    /**
     * Filename for the attached image.
     *
     * @var string
     */
    public $filename;

    /**
     * Attach origin al image to attachment.
     *
     * @param string   $src
     * @param int|null $height
     * @param int|null $width
     *
     * @return $this
     */
    public function original($src, $height, $width)
    {
        if (!filter_var($src, FILTER_VALIDATE_URL)) {
            throw CouldNotSendNotification::flockAttachmentViewImageException('Source of image in attachment is missing or invalid.');
        }
        $this->original['src'] = $src;

        if (!filter_var($height, FILTER_VALIDATE_INT) or $height <= 0) {
            throw CouldNotSendNotification::flockAttachmentViewImageException('Height of image in attachment is missing or invalid.');
        }
        $this->original['height'] = $height;

        if (!filter_var($width, FILTER_VALIDATE_INT) or $width <= 0) {
            throw CouldNotSendNotification::flockAttachmentViewImageException('Width of image in attachment is missing or invalid.');
        }
        $this->original['width'] = $width;

        return $this;
    }

    /**
     * Attach thumbnail to attachment.
     *
     * @param string   $src
     * @param int|null $height
     * @param int|null $width
     *
     * @return $this
     */
    public function thumbnail($src, $height, $width)
    {
        if (!filter_var($src, FILTER_VALIDATE_URL)) {
            throw CouldNotSendNotification::flockAttachmentViewImageException('Source of image in attachment is missing or invalid.');
        }
        $this->thumbnail['src'] = $src;

        if (!filter_var($height, FILTER_VALIDATE_INT) or $height <= 0) {
            throw CouldNotSendNotification::flockAttachmentViewImageException('Height of image in attachment is missing or invalid.');
        }
        $this->thumbnail['height'] = $height;

        if (!filter_var($width, FILTER_VALIDATE_INT) or $width <= 0) {
            throw CouldNotSendNotification::flockAttachmentViewImageException('Width of image in attachment is missing or invalid.');
        }
        $this->thumbnail['width'] = $width;

        return $this;
    }

    /**
     * Add file name to attached image.
     *
     * @param string $filename
     *
     * @return $this
     */
    public function filename($filename)
    {
        $this->filename = $filename;

        return $this;
    }
}
