<?php
namespace GdePosylka\Client\Response;

class TrackingInfoShortResponse extends AbstractResponse
{
    /**
     * @var CheckpointResponse|null
     */
    private $lastCheckpoint = null;

    public function __construct($data)
    {
        parent::__construct($data);

        if ($this->data['lastCheckpoint']) {
            $this->lastCheckpoint = new CheckpointResponse(array('result' => $this->data['lastCheckpoint']));
        }
    }

    /**
     * @return CheckpointResponse|null
     */
    public function getLastCheckpoint()
    {
        return $this->lastCheckpoint;
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
    public function getTrackingNumber()
    {
        return $this->data['tracking_number'];
    }

    /**
     * @return string
     */
    public function isDelivered()
    {
        return $this->data['is_delivered'];
    }

    /**
     * @return \DateTime
     */
    public function getLastCheck()
    {
        return new \DateTime($this->data['last_check']);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return !empty($this->data['title']) ? $this->data['title'] : '';
    }
}