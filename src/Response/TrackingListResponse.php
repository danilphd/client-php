<?php
namespace GdePosylka\Client\Response;

class TrackingListResponse extends AbstractResponse
{
    /**
     * @var TrackingInfoShortResponse[]
     */
    private $trackings;

    public function __construct($data)
    {
        parent::__construct($data);

        foreach ($this->data as $courier) {
            $this->trackings[] = new TrackingInfoShortResponse(array('result' => $courier));
        }
    }

    /**
     * @return TrackingInfoShortResponse[]
     */
    public function getTrackings()
    {
        return $this->trackings;
    }
}