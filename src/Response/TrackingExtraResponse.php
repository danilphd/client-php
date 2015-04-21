<?php
namespace GdePosylka\Client\Response;

class TrackingExtraResponse extends AbstractResponse
{
    /**
     * @return string
     */
    public function getCourierSlug()
    {
        return $this->data['courier_slug'];
    }

    /**
     * @return object
     */
    public function getData()
    {
        return $this->data['data'];
    }
}