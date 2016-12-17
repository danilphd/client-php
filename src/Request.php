<?php
namespace GdePosylka\Client;

use Guzzle\Common\Exception\GuzzleException;
use Guzzle\Http\Client as GuzzleClient;
use Guzzle\Http\Exception\BadResponseException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class Request
{
    private $apiUrl = 'http://gdeposylka.ru/api/v4';
    protected $apiKey = '';
    protected $guzzlePlugins = array();
    private $client;

    /**
     * @param string $apiKey
     * @param string $apiUrl
     * @param array $guzzlePlugins
     * @throws Exception\EmptyApiKey
     */
    public function __construct($apiKey, $apiUrl = '', $guzzlePlugins = array())
    {
        if (empty($apiKey)) {
            throw new Exception\EmptyApiKey();
        }
        $this->apiKey = $apiKey;
        if (!empty($apiUrl)) {
            $this->apiUrl = $apiUrl;
        }
        $this->client = new GuzzleClient();
        if (count($this->guzzlePlugins) > 0) {
            foreach ($this->guzzlePlugins as $plugin) {
                if ($plugin instanceof EventSubscriberInterface) {
                    $this->client->addSubscriber($plugin);
                }
            }
        }
    }

    /**
     * @param $uri
     * @param string $method
     * @param array $options
     * @return array|bool|float|int|string
     * @throws GuzzleException
     */
    public function call($path, $method = 'GET', $options = array())
    {
        $headers = array(
            'x-authorization-token' => $this->apiKey,
            'content-type' => 'application/json'
        );
        
        $uri = sprintf("%s/%s", $this->apiUrl, $path);

        try {
            $request = $this->client->createRequest($method, $uri, $headers, null, $options);
            $response = $request->send()->json();
        } catch (BadResponseException $exception) {
            $response = $exception->getResponse()->json();
        } catch (GuzzleException $exception) {
            throw $exception;
        }

        return $response;
    }

}
