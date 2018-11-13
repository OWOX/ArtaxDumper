<?php

namespace ArtaxDumper\Request;

use Amp\Artax\Request;

interface RequestDumper
{
    public function dump(Request $request): string;
}