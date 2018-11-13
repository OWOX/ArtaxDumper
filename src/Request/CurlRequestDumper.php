<?php

namespace ArtaxDumper\Request;

use Amp\Artax\Request;
use function Amp\Promise\wait;

final class CurlRequestDumper implements RequestDumper
{
    public function dump(Request $request): string
    {
        $command = 'curl ';

        foreach ($request->getHeaders() as $key => $values) {
            foreach ($values as $value) {
                $command .= "-H \"{$key}: $value\" ";
            }
        }

        $body = wait($request->getBody()->createBodyStream()->read());

        if (null !== $body && '' !== $body) {
            $command .= '-d "' . addslashes($body) . '" ';
        }

        return $command . '"' . $request->getUri() . '"';
    }
}
