<?php
namespace GdePosylka\Client;

class Client
{
    /*
     * ☐ Доступные службы доставки
     * ☐ Определение службы по трек-номеру
     * ☑ Отслеживание посылки по службе и трек-номеру
     */

    /**
     * @var Request
     */
    protected $request;

    /**
     * @param string $apiKey
     * @param string $apiUrl
     * @param array $guzzlePlugins
     */
    public function __construct($apiKey, $apiUrl = '', $guzzlePlugins = array())
    {
        $this->request = new Request($apiKey, $apiUrl, $guzzlePlugins);
    }

    /**
     * @return Request
     */
    protected function getRequest()
    {
        return $this->request;
    }

    /**
     * Отслеживание посылки по службе и трек-номеру
     * 
     * @param $courierSlug
     * @param $trackingNumber
     * @return Response\TrackingInfoResponse
     * @throws Exception\EmptyCourierSlug
     * @throws Exception\EmptyTrackingNumber
     * @throws \Guzzle\Common\Exception\GuzzleException
     */
    public function getTrackingInfo($courierSlug, $trackingNumber)
    {
        if (empty($courierSlug)) {
            throw new Exception\EmptyCourierSlug;
        }
        if (empty($trackingNumber)) {
            throw new Exception\EmptyTrackingNumber;
        }
        $path = sprintf("tracker/%s/%s", $courierSlug, $trackingNumber);
        $response = $this->getRequest()->call($path);
        
        return new Response\TrackingInfoResponse($response);
    }

}
