<?php

namespace spec\ArtaxDumper\Request;

use Amp\Artax\Request;
use ArtaxDumper\Request\CurlRequestDumper;
use ArtaxDumper\Request\RequestDumper;
use PhpSpec\ObjectBehavior;

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

        $this->dump($request)->shouldResolveTo("curl \"{$uri}\"");
    }

    function it_dumps_get_request_with_data()
    {
        $request = (new Request($uri = 'https://httpbin.org/get'))
            ->withBody($body = 'foo=bar');

        $this->dump($request)->shouldResolveTo("curl -G -d \"{$body}\" \"{$uri}\"");
    }

    function it_sets_flag_when_response_headers_should_not_be_hidden()
    {
        $request = new Request($uri = 'https://httpbin.org/get');

        $this->dump($request, false)->shouldResolveTo("curl -i \"{$uri}\"");
    }

    function it_dumps_post_request()
    {
        $request = (new Request($uri = 'https://httpbin.org/post', 'POST'))
            ->withBody($body = 'foo=bar');

        $this->dump($request)->shouldResolveTo("curl -d \"{$body}\" \"{$uri}\"");
    }

    function it_dumps_put_request()
    {
        $request = (new Request($uri = 'https://httpbin.org/put', 'PUT'))
            ->withBody($body = 'foo=bar');

        $this->dump($request)->shouldResolveTo("curl -X PUT -d \"{$body}\" \"{$uri}\"");
    }

    function it_dumps_request_with_headers()
    {
        $request = (new Request($uri = 'https://httpbin.org/get'))
            ->withHeaders([
                $key = 'foo' => $value = 'bar',
            ]);

        $this->dump($request)->shouldResolveTo("curl -H \"{$key}: $value\" \"{$uri}\"");
    }
}
