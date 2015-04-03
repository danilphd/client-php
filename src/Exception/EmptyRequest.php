<?php
namespace GdePosylka\Client\Exception;

class EmptyRequest extends ClientException
{
    protected $message = 'Request cannot be empty';
}