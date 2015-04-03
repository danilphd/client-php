<?php
namespace GdePosylka\Client\Response;

class CourierDetectResponse extends AbstractResponse
{
    /**
     * @var CourierResponse[]
     */
    private $couriers;

    public function __construct($data)
    {
        parent::__construct($data);

        foreach ($this->data['couriers'] as $courier) {
            $this->couriers[] = new CourierResponse(array('result' => $courier));
        }
    }

    /**
     * @return CourierResponse[]
     */
    public function getCouriers()
    {
        return $this->couriers;
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        return $this->data['total'];
    }

    /**
     * @return string
     */
    public function getTrackingNumber()
    {
        return $this->data['tracking_number'];
    }
}