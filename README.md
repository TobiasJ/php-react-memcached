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

```php
$loop = React\EventLoop\Factory::create();
$factory = new Factory($loop);

$factory
    ->createClient('localhost:11211')
    ->then(function (Client $client) {
        $client->set('example', 'Hello world');

        $client->get('example')->then(function ($data) {
            echo $data . PHP_EOL; // Hello world
        });

        // Close the connection when all requests are resolved
        $client->end();
});

$loop->run();
```
See [other examples](https://github.com/seregazhuk/php-memcached-react/tree/master/examples).

## Connection

You can connect to server and create a client via the factory. It requires an instance of the `EventLoopInterface`:

```php
$loop = React\EventLoop\Factory::create();
$factory = new Factory($loop);
```

Then to create a client call `createClient()` method and pass a connection string:
```php
$factory->createClient('localhost:11211'')->then(
    function (Client $client) {
        // client connected
    },
    function (Exception $e) {
        // an error occurred while trying to connect 
    }
);
```

This method returns a promise. If connection was established the promise resolves with an instance of the `Client`. If 
something went wrong and connection wasn't established the promise will be rejected.

## Client

For each memcached command a client has a method. All commands are executed asynchronously. The client stored pending 
requests and once it receives the response from the server, it starts resolving these requests. That means that each 
command returns a promise. When the server executed a command and returns a response, the promise will be resolved 
with this response. If there was an error, the promise will be rejected. 

## Retrieval Commands

### Get
Get value from key:

```php
$client
    ->get('some-key')
    ->then(function ($data) {
        echo "Retreived value: " . $data . PHP_EOL; 
    });
```

## Storage Commands
For `$flags` you can use PHP `MEMCACHE_COMPRESSED` constant to specify on-the-fly compression.

### Set
Store key/value pair in Memcached:

```php
$client
    ->set('some-key', 'my-data')
    ->then(function () {
        echo "Value was stored" . PHP_EOL;
    });
    
// advanced
$client
    ->set('some-key', 'my-data', $falgs, $exptime)
    ->then(function () {
        echo "Value was stored" . PHP_EOL;
    });    
```

### Add
Store key/value pair in Memcached, but only if the server **doesn’t** already hold data for this key:

```php
$client
    ->add('name', 'test')
    ->then(function() {
        echo "The value was added" . PHP_EOL;
    });
    
    
// advanced   
$client
    ->add('name', 'test', $flags, $exptime)
    ->then(function() {
        echo "The value was added" . PHP_EOL;
    });    
```

### Replace

Store key/value pair in Memcached, but only if the server already hold data for this key:
```php
$client
    ->replace('name', 'test')
    ->then(function(){
        echo "The value was replaced" . PHP_EOL;
    });
 
// advanced    
$client
    ->replace('name', 'test', $flags, $exptime)
    ->then(function(){
        echo "The value was replaced" . PHP_EOL;
    });    
```

## Delete
Delete value by key from Memcached:

```php
$client
    ->delete('name')
    ->then(function(){
        echo "The value was deleted" . PHP_EOL;
});
```

## Increment/Decrement Commands

### Increment
Increment value associated with key in Memcached, item **must** exist, increment command will not create it.
The limit of increment is the 64 bit mark:

```php
$client
    ->incr('var', 2)
    ->then(function($data){
        "New value is: " . $data . PHP_EOL;
    });
```

### Decrement
Decrement value associated with key in Memcached, item **must** exist, decrement command will not create it
If you try to decrement a value bellow 0, value will stay at 0:

```php
$client
    ->decr('var', 2)
    ->then(function($data){
        "New value is: " . $data . PHP_EOL;
    });
```
