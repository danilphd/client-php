<?php
namespace GdePosylka\Client\Exception;

class EmptyTrackingNumber extends ClientException
{
    protected $message = 'Tracking number cannot be empty';
}