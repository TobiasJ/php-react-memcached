# Memcached ReactPHP Client
Asynchronous Memcached PHP Client for [ReactPHP](http://reactphp.org/) ecosystem.

[![Build Status](https://travis-ci.org/seregazhuk/php-memcached-react.svg?branch=master)](https://travis-ci.org/seregazhuk/php-memcached-react)

## Installation

### Dependencies
Library requires PHP 5.6.0 or above.

The recommended way to install this library is via [Composer](https://getcomposer.org). 
[New to Composer?](https://getcomposer.org/doc/00-intro.md)

```
composer require ?
```

## Quick Start

$loop = React\EventLoop\Factory::create();
$factory = new Factory($loop);

$factory->createClient('localhost')->then(function (Client $client) use ($loop) {
    $client->set('example', 'Hello world');
    
    $client->get('example')->then(function ($data) {        
        echo $data . PHP_EOL; // Hello world
    });
    
    $client->close();
});

$loop->run();
