<?php
namespace GdePosylka\Client\Response;

class CourierResponse extends AbstractResponse
{
    /**
     * @return string
     */
    public function getCountryCode()
    {
        return $this->data['country_code'];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->data['name'];
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->data['slug'];
    }

    /**
     * @return string
     */
    public function getTrackingNumber()
    {
        return !empty($this->data['tracking_number']) ? $this->data['tracking_number'] : null;
    }
}