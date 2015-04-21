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

        foreach ($this->data['trackings'] as $courier) {
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

    public function getPerPage()
    {
        return $this->data['per_page'];
    }

    public function getCurrentPage()
    {
        return $this->data['cur_page'];
    }

    public function getCountTotal()
    {
        return $this->data['total'];
    }

    public function getCountOnPage()
    {
        return $this->data['on_page'];
    }
}