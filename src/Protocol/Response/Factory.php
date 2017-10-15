<?php

namespace seregazhuk\React\Memcached\Protocol\Response;

use seregazhuk\React\Memcached\Protocol\Exception\WrongCommandException;
use seregazhuk\React\Memcached\Protocol\Parser;

class Factory
{
    /**
     * @param string $command
     * @param string $data
     * @return Response
     * @throws WrongCommandException
     */
    public function makeByCommand($command, $data)
    {
        switch($command) {
            case Parser::COMMAND_GET:
                return new ReadResponse($data);
            case Parser::COMMAND_SET:
            case Parser::COMMAND_ADD:
            case Parser::COMMAND_REPLACE:
                return new WriteResponse($data);
            case Parser::COMMAND_VERSION:
                return new VersionResponse($data);
            case Parser::COMMAND_STATS:
                return new StatsResponse($data);
            case Parser::COMMAND_TOUCH:
                return new TouchResponse($data);
            case Parser::COMMAND_DELETE:
                return new DeleteResponse($data);
            case Parser::COMMAND_VERBOSITY:
            case Parser::COMMAND_FLUSH_ALL:
                return new OkResponse($data);
            case Parser::COMMAND_INCREMENT:
            case Parser::COMMAND_DECREMENT:
                return new ValueResponse($data);
        }

        throw new WrongCommandException("Unknown command: $command");
    }
}
