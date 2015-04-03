<?php
namespace GdePosylka\Client\Response;

class CheckpointResponse extends AbstractResponse
{
    /**
     * @return \DateTime
     */
    public function getTime()
    {
        return new \DateTime($this->data['time']);
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->data['status'];
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->data['message'];
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return !empty($this->data['location']) ? $this->data['location'] : null;
    }

    /**
     * @return string
     */
    public function getZipCode()
    {
        return !empty($this->data['zip_code']) ? $this->data['zip_code'] : null;
    }

    /**
     * @return string
     */
    public function getCourierSlug()
    {
        return $this->data['courier_slug'];
    }

    /**
     * @return string
     */
    public function getCountryCode()
    {
        return $this->data['country_code'];
    }
}