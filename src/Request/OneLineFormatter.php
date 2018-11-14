<?php

namespace ArtaxDumper\Request;

/** @internal */
final class OneLineFormatter implements Formatter
{
    public function format(array $commandParts): string
    {
        return implode(' ', array_filter(iterator_to_array(new \RecursiveIteratorIterator(new \RecursiveArrayIterator($commandParts)))));
    }
}