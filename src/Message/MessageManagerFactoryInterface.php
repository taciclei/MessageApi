<?php

namespace App\Message;

use App\Client\RequestApiInterface;
use App\Message\Parser\MessagesParserInterface;

interface MessageManagerFactoryInterface
{
    public function createMessageManager(RequestApiInterface $request): MessagesParserInterface;
}