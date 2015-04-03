<?php
namespace GdePosylka\Client\Exception;

class EmptyApiKey extends ClientException
{
    protected $message = 'API key cannot be empty';
}