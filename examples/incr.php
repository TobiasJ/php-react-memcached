<?php

use seregazhuk\React\Memcached\Factory;
use seregazhuk\React\Memcached\Client;

require '../vendor/autoload.php';

$loop = React\EventLoop\Factory::create();
$factory = new Factory($loop);

$factory->createClient('localhost:11211')->then(
    function (Client $client) {
        //$client->set('var', 9)->then(function($result){
        //    var_dump($result);
        //    echo "The value was stored\n";
        //});
        $client->set('var', 2);
        $client->incr('var', 2)->then(function($data){
            var_dump($data);
        });
    },
    function(Exception $e){
        echo $e->getMessage(), "\n";
    });

$loop->run();
