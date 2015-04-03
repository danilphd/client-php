<?php
namespace GdePosylka\Client\Tests;

use GdePosylka\Client\Response\CourierListResponse as Response;

class ResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \GdePosylka\Client\Response\Exception\BadRequest
     */
    public function testBadRequestCode()
    {
        new Response(array('error' => array('code' => -32700, 'message' => 'Bad Request')));
    }

    /**
     * @expectedException \GdePosylka\Client\Response\Exception\ServerError
     */
    public function testServerErrorCode()
    {
        new Response(array('error' => array('code' => -32603, 'message' => 'ServerError')));
    }

    /**
     * @expectedException \GdePosylka\Client\Response\Exception\AuthRequired
     */
    public function testAuthRequiredCode()
    {
        new Response(array('error' => array('code' => 401, 'message' => 'AuthRequired')));
    }

    /**
     * @expectedException \GdePosylka\Client\Response\Exception\MethodNotAllowed
     */
    public function testMethodNotAllowedCode()
    {
        new Response(array('error' => array('code' => -32601, 'message' => 'MethodNotAllowed')));
    }

    /**
     * @expectedException \GdePosylka\Client\Response\Exception\ResponseException
     */
    public function testMissingMetaCode()
    {
        new Response(array());
    }

    /**
     * @expectedException \GdePosylka\Client\Response\Exception\ResponseException
     */
    public function testUnknownCode()
    {
        new Response(array('error' => array('code' => 459)));
    }

}