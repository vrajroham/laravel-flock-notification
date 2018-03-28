<?php

namespace Vrajroham\LaravelFlockNotification;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use Vrajroham\Flock\Exceptions\CouldNotSendNotification;

class Flock
{
    /** @var HttpClient HTTP Client */
    protected $http;

    /**
     * @param HttpClient|null $httpClient
     */
    public function __construct(HttpClient $httpClient = null)
    {
        $this->http = $httpClient;
    }

    /**
     * Get HttpClient.
     *
     * @return HttpClient
     */
    protected function httpClient()
    {
        return $this->http ?: $this->http = new HttpClient();
    }

    /**
     * @param $url
     * @param $params
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws CouldNotSendNotification
     */
    public function sendMessage($url, $params)
    {
        return $this->sendRequest($url, $params);
    }

    /**
     * @param $endpoint
     * @param $params
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function sendRequest($endpoint, $params)
    {
        try {

            return $this->httpClient()->post($endpoint, [
                'json' => $params,
            ]);
        } catch (ClientException $exception) {
            throw CouldNotSendNotification::flockRespondedWithAnError($exception);
        }
    }
}
