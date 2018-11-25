<?php

namespace ArtaxDumper\Request;

use Amp\Artax\Request;
use Amp\Promise;

interface RequestDumper
{
    public function dump(Request $request): Promise;
}