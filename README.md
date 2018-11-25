# ArtaxDumper - dump [Artax](https://github.com/amphp/artax) requests and responses for logging and debugging

[![Build Status](https://travis-ci.com/OWOX/ArtaxDumper.svg?branch=master)](https://travis-ci.com/Sevavietl/ArtaxDumper)
[![Coverage Status](https://coveralls.io/repos/github/OWOX/ArtaxDumper/badge.svg?branch=master)](https://coveralls.io/github/OWOX/ArtaxDumper?branch=master)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![PHPStan](https://img.shields.io/badge/PHPStan-enabled-brightgreen.svg?style=flat)](https://github.com/phpstan/phpstan)

Install it with:

```bash
composer require owox/artax-dumper
```

Only [curl](https://curl.haxx.se/) request dumper hugely inspired by [cuzzle](https://github.com/namshi/cuzzle) available for now. It can be used for copy/paste requests logging:

```php
$curlRequestDumper = new \ArtaxDumper\Request\CurlRequestDumper();

// GET Request
$request = new \Amp\Artax\Request('https://httpbin.org/get');

$curl = $curlRequestDumper->dump($request); // => curl "https://httpbin.org/get"

// POST Request
$request = (new \Amp\Artax\Request($uri = 'https://httpbin.org/post', 'POST'))
    ->withBody($body = 'foo=bar');

$curl = $curlRequestDumper->dump($request); // => curl -d "foo=bar" "https://httpbin.org/post"
```