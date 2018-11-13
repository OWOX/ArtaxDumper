<?php

namespace spec\ArtaxDumper\Request;

use Amp\Artax\Request;
use ArtaxDumper\Request\CurlRequestDumper;
use ArtaxDumper\Request\RequestDumper;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CurlRequestDumperSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(CurlRequestDumper::class);
    }

    function it_is_request_dumper()
    {
        $this->shouldHaveType(RequestDumper::class);
    }

    function it_dumps_get_request()
    {
        $request = new Request($uri = 'https://httpbin.org/get');

        $this->dump($request)->shouldReturn("curl \"{$uri}\"");
    }

    function it_dumps_post_request()
    {
        $request = (new Request($uri = 'https://httpbin.org/get', 'POST'))
            ->withBody($body = 'foo=bar');

        $this->dump($request)->shouldReturn("curl -d \"{$body}\" \"{$uri}\"");
    }

    function it_dumps_request_with_headers()
    {
        $request = (new Request($uri = 'https://httpbin.org/get'))
            ->withHeaders([
                $key = 'foo' => $value = 'bar',
            ]);

        $this->dump($request)->shouldReturn("curl -H \"{$key}: $value\" \"{$uri}\"");
    }
}
