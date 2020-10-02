<?php


namespace App\Message;

use App\Message\Parser\MessagesParserInterface;

class MessagesFactory
{
    public function getClassName(string $parser) {

        $class = MessagesParserInterface::PARSERS[$parser];

        if (class_exists($class)) {
            return $class;
        } else {
            throw new \Exception('class not exist' . $class);
        }
    }

    function create(string $parser): MessagesParserInterface
    {
        $className = $this->getClassName($parser);

        return new $className;

    }
}
