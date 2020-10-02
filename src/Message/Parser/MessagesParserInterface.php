<?php


namespace App\Message\Parser;

use App\Message\MessagesCollection;

interface MessagesParserInterface
{

    const JSON = JsonParser::class;
    const XML = XmlParser::class;
    const PARSERS = ['json' => self::JSON, 'xml' => self::XML];

    function getMessages(string $messages): MessagesCollection;
}