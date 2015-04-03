<?php
namespace GdePosylka\Client\Response;

class TrackingResponse extends AbstractResponse
{
    /**
     * @return string
     */
    public function getCourierSlug()
    {
        return $this->data['tracking']['courier_slug'];
    }

    /**
     * @return string
     */
    public function getTrackingNumber()
    {
        return $this->data['tracking']['tracking_number'];
    }
}