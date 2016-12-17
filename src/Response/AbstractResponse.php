<?php
namespace GdePosylka\Client\Response;

abstract class AbstractResponse
{
    /**
     * @var array
     */
    protected $data;

    public function __construct($data)
    {
        $error = 'Unknown error';
        if (!empty($data['result'])) {
            if ($data['result'] != 'error') {
                $this->data = $data['data'];

                return;
            } else {
                $error = $data['error'];
            }
        }

        throw new Exception\ResponseException($error, 0);
    }
}