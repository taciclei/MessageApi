<?php

namespace App\Client;

use App\Message\MessagesCollection;

interface ClientApiInterface
{
    public function sendRequest(RequestApi $request);

    public function getBody();
}