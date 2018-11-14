<?php

namespace ArtaxDumper\Request;

use Amp\Artax\Request;
use function Amp\Promise\wait;

final class CurlRequestDumper implements RequestDumper
{
    /** @var Formatter */
    private $formatter;

    public function __construct(Formatter $formatter = null)
    {
        $this->formatter = $formatter ?? new OneLineFormatter();
    }

    public function dump(Request $request, bool $hideResponseHeaders = true): string
    {
        $commandParts = [];
        $commandParts['base'] = 'curl';
        $commandParts['hideResponseHeaders'] = $hideResponseHeaders ? null : '-i';
        $commandParts['method'] = null;
        $commandParts['headers'] = [];

        foreach ($request->getHeaders() as $key => $values) {
            foreach ($values as $value) {
                $commandParts['headers'][] = "-H \"{$key}: $value\"";
            }
        }

        $body = wait($request->getBody()->createBodyStream()->read());

        if (null !== $body && '' !== $body) {
            $commandParts['body'] = '-d "' . addslashes($body) . '"';

            if ('GET' === $request->getMethod()) {
                $commandParts['method'] = '-G';
            }
        }

        if ('PUT' === $request->getMethod()) {
            $commandParts['method'] = '-X PUT';
        }

        $commandParts['uri'] = '"' . $request->getUri() . '"';

        return $this->formatter->format($commandParts);
    }


}
