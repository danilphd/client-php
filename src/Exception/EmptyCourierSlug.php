<?php
namespace GdePosylka\Client\Exception;

class EmptyCourierSlug extends ClientException
{
    protected $message = 'Courier cannot be empty';
}