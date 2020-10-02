<?php

namespace App\Client;

use App\Message\Parser\MessagesParserInterface;

class ClientApi implements ClientApiInterface
{
    public $parser;
    public $request;
    public $body;
    public $response;
    /**
     * @var MessagesParserInterface
     */
    public $messageManager;

    /**
     * ClientApi constructor.
     * @param MessagesParserInterface $messageManager
     */

    public function __construct(MessagesParserInterface $messageManager)
    {
        $this->messageManager = $messageManager;
    }

    public function sendRequest(RequestApi $request)
    {
        $this->request = $request;
        $this->response = $this->messageManager->getMessages($this->getBody());
    }

    /**
     * @return mixed
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    public function getBody()
    {
        $this->body = '{
  "messages": {
    "12": {
      "message": "Hello, I want to rent your boat",
      "tenantId": "1505"
    },
    "14": {
      "message": "Did you receive my message?",
      "tenantId": "1505"
    },
    "23": {
      "message": "Yes. Sorry. For which dates?",
      "ownerId": "2546"
    },
    "35": {
      "message": "The 15 of April 2018 to the 20 of April 2018.",
      "tenantId": "1505"
    },
    "48": {
      "message": "Ok, no problem, let me send you a custom offer!",
      "ownerId": "2546"
    }
  }
}';
        return $this->body;
    }
}