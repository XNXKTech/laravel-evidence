<?php

declare(strict_types=1);

namespace Tests\Adapter;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use Tests\TestCase;
use XNXK\LaravelEvidence\Adapter\ResponseException;

/**
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class ResponseExceptionTest extends TestCase
{
    public function testFromRequestExceptionNoResponse()
    {
        $reqErr = new RequestException('foo', new Request('GET', '/test'));
        $respErr = ResponseException::fromRequestException($reqErr);

        $this->assertInstanceOf(ResponseException::class, $respErr);
        $this->assertEquals($reqErr->getMessage(), $respErr->getMessage());
        $this->assertEquals(0, $respErr->getCode());
        $this->assertEquals($reqErr, $respErr->getPrevious());
    }
}
