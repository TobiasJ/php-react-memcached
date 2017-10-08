<?php

use seregazhuk\React\Memcached\Factory;
use seregazhuk\React\Memcached\Client;

require 'vendor/autoload.php';

$loop = React\EventLoop\Factory::create();
$factory = new Factory($loop);

$factory->createClient('localhost:11211')->then(
	function (Client $client) use ($loop){
        $client->set('key1', 'test');
        $client->get('key1')->then('var_dump');
	},
	function(Exception $e){
		print_r($e->getMessage());
	});

$loop->run();
