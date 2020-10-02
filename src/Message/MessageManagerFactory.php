<?php


namespace App\Message;

use App\Client\RequestApiInterface;
use App\Message\Parser\JsonParser;
use App\Message\Parser\MessagesParserInterface;
use App\Message\Parser\XmlParser;

class MessageManagerFactory implements MessageManagerFactoryInterface
{

    public function createMessageManager(RequestApiInterface $request): MessagesParserInterface
    {
        $class = MessagesParserInterface::PARSERS[$request->getParser()];
        if (!class_exists($class)) {
            throw new \Exception('class not exist' . $class);
        }

        return new $class;

    }

}