<?php

namespace ArtaxDumper\Test\Integration\Request;

use Amp\Artax\Request;
use ArtaxDumper\Request\CurlRequestDumper;
use PHPUnit\Framework\TestCase;

final class CurlRequestDumperTest extends TestCase
{
    /** @var CurlRequestDumper */
    private $curlRequestDumper;

    protected function setUp()
    {
        $this->curlRequestDumper = new CurlRequestDumper();
    }

    public function testDumpsValidGetRequest(): void
    {
        $request = new Request('https://httpbin.org/get');

        $this->assertValidCurlRequest($this->curlRequestDumper->dump($request, false));
    }

    public function testDumpsValidGetRequestWithData(): void
    {
        $request = (new Request($uri = 'https://httpbin.org/get'))
            ->withBody($body = 'foo=bar');

        $this->assertValidCurlRequest($this->curlRequestDumper->dump($request, false));
    }

    public function testDumpsValidPostRequest(): void
    {
        $request = (new Request($uri = 'https://httpbin.org/post', 'POST'))
            ->withBody($body = 'foo=bar');

        $this->assertValidCurlRequest($this->curlRequestDumper->dump($request, false));
    }

    public function testDumpsValidPutRequest(): void
    {
        $request = (new Request($uri = 'https://httpbin.org/put', 'PUT'))
            ->withBody($body = 'foo=bar');

        $this->assertValidCurlRequest($this->curlRequestDumper->dump($request, false));
    }

    public function testDumpsValidRequestWithHeaders()
    {
        $request = (new Request($uri = 'https://httpbin.org/get'))
            ->withHeaders([
                $key = 'foo' => $value = 'bar',
            ]);

        $this->assertValidCurlRequest($this->curlRequestDumper->dump($request, false));
    }

    private function assertValidCurlRequest(string $curl): void
    {
        $response = shell_exec($curl) ?? '';

        $this->assertRegExp('/200 OK/', $response);
    }
}