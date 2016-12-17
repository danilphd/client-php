<?php
namespace GdePosylka\Client\Response;

class TrackingInfoResponse extends AbstractResponse
{
    /**
     * @var CheckpointResponse[]
     */
    private $checkpoints = [ ];

    /**
     * @var TrackingExtraResponse[]
     */
    private $extra = [ ];

    public function __construct($data)
    {
        parent::__construct($data);

        foreach ($this->data['checkpoints'] as $checkpoint) {
            $this->checkpoints[] = new CheckpointResponse([
                'result' => 'success',
                'data' => $checkpoint,
            ]);
        }
        foreach ($this->data['extra'] as $extra) {
            $this->extra[] = new TrackingExtraResponse([
                'result' => 'success',
                'data' => $extra,
            ]);
        }
    }

    /**
     * @return CheckpointResponse[]
     */
    public function getCheckpoints()
    {
        return $this->checkpoints;
    }

    /**
     * @return TrackingExtraResponse[]
     */
    public function getExtra()
    {
        return $this->extra;
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

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->data['status'];
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->data['is_active'];
    }
}