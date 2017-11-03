<?php

namespace seregazhuk\React\Memcached;

use React\EventLoop\LoopInterface;
use React\Socket\Connector;
use seregazhuk\React\Memcached\Protocol\Parser;
use seregazhuk\React\Memcached\Protocol\Response\Factory as ResponseFactory;
use seregazhuk\React\Memcached\Protocol\Request\Factory as RequestFactory;

class Factory
{
    /**
     * Creates a memcached client
     * @param LoopInterface $loop
     * @param string $address
     * @return Client
     */
    public static function createClient(LoopInterface $loop, $address = 'localhost:11211')
    {
        return new Client(self::createConnection($loop, $address),  self::createProtocolParser());
    }

    /**
     * @return Parser
     */
    protected static function createProtocolParser()
    {
        return new Parser(new RequestFactory(), new ResponseFactory());
    }

    /**
     * @param LoopInterface $loop
     * @param $address
     * @return Connection
     */
    protected static function createConnection(LoopInterface $loop, $address)
    {
        return new Connection($address, new Connector($loop));
    }
}
