<?php

namespace Vrajroham\LaravelFlockNotification\Exceptions;

use GuzzleHttp\Exception\ClientException;

class CouldNotSendNotification extends \Exception
{
    /**
     * Generic method to show the exception.
     *
     * @return static
     */
    public static function serviceRespondedWithAnError()
    {
        return new static('Descriptive error message.');
    }

    /**
     * Thrown when there's a bad request and an error is responded.
     *
     * @param ClientException $exception
     *
     * @return static
     */
    public static function flockRespondedWithAnError(ClientException $exception)
    {
        $statusCode = $exception->getResponse()->getStatusCode();
        $description = 'no description given';
        if ($result = json_decode($exception->getResponse()->getBody())) {
            $description = $result->description ?: $description;
        }

        return new static("Flock responded with an error `{$statusCode} - {$description}`. Check your notification fields.");
    }

    /**
     * Thrown when there is no Incoming webhook url provided.
     *
     * @return static
     */
    public static function flockRouteNotProvided()
    {
        return new static('Flock incoming webhook url not provided.');
    }

    /**
     * Thrown when attachment views widget source, height, width is not provided or invalid.
     *
     * @return static
     */
    public static function flockAttachmentViewWidgetException($exception)
    {
        return new static($exception);
    }

    /**
     * Thrown when attachment views inline html source, height, width is not provided or invalid.
     *
     * @return static
     */
    public static function flockAttachmentViewHtmlException($exception)
    {
        return new static($exception);
    }

    /**
     * Thrown when attachment views image source, height, width is not provided or invalid.
     *
     * @return static
     */
    public static function flockAttachmentViewImageException($exception)
    {
        return new static($exception);
    }

    /**
     * Thrown when attachment URL field not provided or invalid.
     *
     * @return static
     */
    public static function flockAttachmentUrlException($exception)
    {
        return new static($exception);
    }

    /**
     * Thrown when attachment forward field is non boolean.
     *
     * @return static
     */
    public static function flockAttachmentForwardException($exception)
    {
        return new static($exception);
    }

    /**
     * Thrown when attachment download field source is invalid or missing.
     *
     * @return static
     */
    public static function flockAttachmentDownloadException($exception)
    {
        return new static($exception);
    }

    /**
     * Thrown when attachment button field has an error.
     *
     * @return static
     */
    public static function flockAttachmentButtonException($exception)
    {
        return new static($exception);
    }

    /**
     * Thrown when message object has invaild values.
     *
     * @return static
     */
    public static function flockMessageException($exception)
    {
        return new static($exception);
    }
}
