<?php
namespace GdePosylka\Client\Response;

class CourierListResponse extends AbstractResponse
{
    /**
     * @var CourierResponse[]
     */
    private $couriers;

    public function __construct($data)
    {
        parent::__construct($data);

        foreach ($this->data as $courier) {
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
}