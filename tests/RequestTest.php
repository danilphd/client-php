<?php
namespace GdePosylka\Client\Tests;

use GdePosylka\Client\Request;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \GdePosylka\Client\Exception\EmptyApiKey
     * @throws \GdePosylka\Client\Exception\EmptyApiKey
     */
    public function testConstructEmptyApiKey()
    {
        new Request('');
    }
}