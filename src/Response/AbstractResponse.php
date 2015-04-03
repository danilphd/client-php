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
        if (empty($data['error']) && !empty($data['result'])) {
            $this->data = $data['result'];
        } else {
            if (empty($data['error']['code'])) {
                $data['error']['code'] = 0;
            }
            if (empty($data['error']['message'])) {
                $data['error']['message'] = 'Unknown error';
            }

            switch ($data['error']['code']) {
                case -32700:
                case -32600:
                case -32602:
                    throw new Exception\BadRequest($data['error']['message'], $data['error']['code']);
                    break;
                case -32601:
                    throw new Exception\MethodNotAllowed($data['error']['message'], $data['error']['code']);
                    break;
                case -32603:
                    throw new Exception\ServerError($data['error']['message'], $data['error']['code']);
                    break;
                case 401:
                    throw new Exception\AuthRequired($data['error']['message'], $data['error']['code']);
                    break;
                case 403:
                    throw new Exception\AccessDenied($data['error']['message'], $data['error']['code']);
                    break;
                default:
                    throw new Exception\ResponseException($data['error']['message'], $data['error']['code']);
            }
        }
    }
}