<?php

namespace ArtaxDumper\Request;

interface Formatter
{
    public function format(array $commandParts): string;
}