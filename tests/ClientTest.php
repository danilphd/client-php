<?php
namespace GdePosylka\Client\Tests;

use GdePosylka\Client\Client;
use GdePosylka\Client\TrackingFields;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    const USPS_SLUG = 'usps';
    const USPS_TRACKING_NUMBER = 'EC208786464US';

    /**
     * @var Client
     */
    private $client = null;

    protected function getClient()
    {
        if (!($apiKey = getenv('API_KEY'))) {
            $apiKey = API_KEY;
        }
        if ($this->client === null) {
            $this->client = new Client($apiKey);
        }

        return $this->client;
    }

    public function testGetCouriers()
    {
        $response = $this->getClient()->getCouriers();
        $this->assertInstanceOf('\GdePosylka\Client\Response\CourierListResponse', $response);
        $this->assertNotEmpty($response->getCouriers());
        foreach ($response->getCouriers() as $couriers) {
            $this->assertNotEmpty($couriers->getName());
            $this->assertNotEmpty($couriers->getSlug());
            $this->assertNotEmpty($couriers->getCountryCode());
        }
    }

    public function testDetectCourier()
    {
        $response = $this->getClient()->detectCourier(self::USPS_TRACKING_NUMBER);
        $this->assertInstanceOf('\GdePosylka\Client\Response\CourierDetectResponse', $response);
        $this->assertNotEmpty($response->getTotal());
        $this->assertNotEmpty($response->getTrackingNumber());
        $this->assertNotEmpty($response->getCouriers());
        foreach ($response->getCouriers() as $couriers) {
            $this->assertNotEmpty($couriers->getName());
            $this->assertNotEmpty($couriers->getSlug());
            $this->assertNotEmpty($couriers->getCountryCode());
        }
    }

    /**
     * @expectedException \GdePosylka\Client\Exception\EmptyTrackingNumber
     * @throws \GdePosylka\Client\Exception\EmptyTrackingNumber
     */
    public function testDetectEmptyTrackingNumber(){
        $this->getClient()->detectCourier('');
    }

    public function testGetValidCouriers()
    {
        $response = $this->getClient()->getValidCouriers(self::USPS_TRACKING_NUMBER);
        $this->assertInstanceOf('\GdePosylka\Client\Response\CourierDetectResponse', $response);
        $this->assertNotEmpty($response->getTotal());
        $this->assertNotEmpty($response->getTrackingNumber());
        $this->assertNotEmpty($response->getCouriers());
        foreach ($response->getCouriers() as $couriers) {
            $this->assertNotEmpty($couriers->getName());
            $this->assertNotEmpty($couriers->getSlug());
            $this->assertNotEmpty($couriers->getCountryCode());
        }
    }

    /**
     * @expectedException \GdePosylka\Client\Exception\EmptyTrackingNumber
     * @throws \GdePosylka\Client\Exception\EmptyTrackingNumber
     */
    public function testGetValidCouriersEmptyTrackingNumber(){
        $this->getClient()->detectCourier('');
    }

    public function testAddTracking()
    {
        $response = $this->getClient()->addTracking(self::USPS_SLUG, self::USPS_TRACKING_NUMBER);
        $this->assertInstanceOf('\GdePosylka\Client\Response\TrackingResponse', $response);
        $this->assertNotEmpty($response->getCourierSlug());
        $this->assertNotEmpty($response->getTrackingNumber());
    }

    public function testUpdateTracking()
    {
        $trackingRequest = new TrackingFields();
        $trackingRequest->setTitle('test edit title1');
        $response = $this->getClient()->updateTracking(self::USPS_SLUG, self::USPS_TRACKING_NUMBER, $trackingRequest);
        $this->assertInstanceOf('\GdePosylka\Client\Response\TrackingResponse', $response);
        $this->assertNotEmpty($response->getCourierSlug());
        $this->assertNotEmpty($response->getTrackingNumber());
    }

    public function testGetTrackingInfo()
    {
        $response = $this->getClient()->getTrackingList('default');
        $this->assertInstanceOf('\GdePosylka\Client\Response\TrackingListResponse', $response);
        $this->assertNotEmpty($response->getTrackings());
        foreach ($response->getTrackings() as $tracking) {
            $this->assertInstanceOf('\GdePosylka\Client\Response\TrackingInfoShortResponse', $tracking);
            $this->assertNotEmpty($tracking->getTrackingNumber());
            $this->assertNotEmpty($tracking->getCourierSlug());
            $this->assertNotEmpty($tracking->getLastCheck());
            $this->assertInternalType('boolean', $tracking->isDelivered());
            $this->assertInstanceOf('\DateTime', $tracking->getLastCheck());
            if ($tracking->getLastCheckpoint()) {
                $checkpoints = $tracking->getLastCheckpoint();
                $this->assertNotEmpty($checkpoints->getTime());
                $this->assertInstanceOf('\DateTime', $checkpoints->getTime());
//                $this->assertNotEmpty($checkpoints->getStatus());
                $this->assertThat(
                    $checkpoints->getLocation(),
                    $this->logicalOr(
                        $this->logicalNot($this->isEmpty()),
                        $this->isNull()
                    )
                );
                $this->assertThat(
                    $checkpoints->getZipCode(),
                    $this->logicalOr(
                        $this->logicalNot($this->isEmpty()),
                        $this->isNull()
                    )
                );
                $this->assertNotEmpty($checkpoints->getCountryCode());
                $this->assertNotEmpty($checkpoints->getCourierSlug());
                $this->assertNotEmpty($checkpoints->getMessage());
            }
        }
    }

    public function testGetTrackingList()
    {
        $response = $this->getClient()->getTrackingInfo(self::USPS_SLUG, self::USPS_TRACKING_NUMBER);
        $this->assertInstanceOf('\GdePosylka\Client\Response\TrackingInfoResponse', $response);
        $this->assertNotEmpty($response->getTrackingNumber());
        $this->assertNotEmpty($response->getCourierSlug());
        $this->assertNotEmpty($response->isDelivered());
        $this->assertNotEmpty($response->getLastCheck());
        $this->assertInstanceOf('\DateTime', $response->getLastCheck());
        $this->assertNotEmpty($response->getCheckpoints());
        foreach ($response->getCheckpoints() as $checkpoints) {
            $this->assertNotEmpty($checkpoints->getTime());
            $this->assertInstanceOf('\DateTime', $checkpoints->getTime());
            $this->assertNotEmpty($checkpoints->getStatus());
            $this->assertThat(
                $checkpoints->getLocation(),
                $this->logicalOr(
                    $this->logicalNot($this->isEmpty()),
                    $this->isNull()
                )
            );
            $this->assertThat(
                $checkpoints->getZipCode(),
                $this->logicalOr(
                    $this->logicalNot($this->isEmpty()),
                    $this->isNull()
                )
            );
            $this->assertNotEmpty($checkpoints->getCountryCode());
            $this->assertNotEmpty($checkpoints->getCourierSlug());
            $this->assertNotEmpty($checkpoints->getMessage());
        }
    }

    public function testReactivateTracking()
    {
        $response = $this->getClient()->reactivateTracking(self::USPS_SLUG, self::USPS_TRACKING_NUMBER);
        $this->assertInstanceOf('\GdePosylka\Client\Response\TrackingResponse', $response);
        $this->assertNotEmpty($response->getCourierSlug());
        $this->assertNotEmpty($response->getTrackingNumber());;
    }

    public function testArchive()
    {
        $response = $this->getClient()->archiveTracking(self::USPS_SLUG, self::USPS_TRACKING_NUMBER);
        $this->assertInstanceOf('\GdePosylka\Client\Response\TrackingResponse', $response);
        $this->assertNotEmpty($response->getCourierSlug());
        $this->assertNotEmpty($response->getTrackingNumber());
    }

    public function testRestore()
    {
        $response = $this->getClient()->restoreTracking(self::USPS_SLUG, self::USPS_TRACKING_NUMBER);
        $this->assertInstanceOf('\GdePosylka\Client\Response\TrackingResponse', $response);
        $this->assertNotEmpty($response->getCourierSlug());
        $this->assertNotEmpty($response->getTrackingNumber());
    }

    public function testDelete()
    {
        $response = $this->getClient()->deleteTracking(self::USPS_SLUG, self::USPS_TRACKING_NUMBER);
        $this->assertInstanceOf('\GdePosylka\Client\Response\TrackingResponse', $response);
        $this->assertNotEmpty($response->getCourierSlug());
        $this->assertNotEmpty($response->getTrackingNumber());
    }

    /**
     * @expectedException \GdePosylka\Client\Exception\EmptyTrackingNumber
     * @throws \GdePosylka\Client\Exception\EmptyTrackingNumber
     */
    public function testGetEmptyTrackingNumber()
    {
        $this->getClient()->getTrackingInfo(self::USPS_SLUG, '');
    }

    /**
     * @expectedException \GdePosylka\Client\Exception\EmptyCourierSlug
     * @throws \GdePosylka\Client\Exception\EmptyCourierSlug
     */
    public function testGetEmptySlug()
    {
        $this->getClient()->getTrackingInfo('', '');
    }

    /**
     * @expectedException \GdePosylka\Client\Exception\EmptyTrackingNumber
     * @throws \GdePosylka\Client\Exception\EmptyTrackingNumber
     */
    public function testCreateEmptyTrackingNumber()
    {
        $this->getClient()->addTracking(self::USPS_SLUG, '');
    }

    /**
     * @expectedException \GdePosylka\Client\Exception\EmptyCourierSlug
     * @throws \GdePosylka\Client\Exception\EmptyCourierSlug
     */
    public function testCreateEmptySlug()
    {
        $this->getClient()->addTracking('', '');
    }

    /**
     * @expectedException \GdePosylka\Client\Exception\EmptyTrackingNumber
     * @throws \GdePosylka\Client\Exception\EmptyTrackingNumber
     */
    public function testReactivateEmptyTrackingNumber()
    {
        $this->getClient()->reactivateTracking(self::USPS_SLUG, '');
    }

    /**
     * @expectedException \GdePosylka\Client\Exception\EmptyCourierSlug
     * @throws \GdePosylka\Client\Exception\EmptyCourierSlug
     */
    public function testReactivateEmptySlug()
    {
        $this->getClient()->reactivateTracking('', '');
    }
}