<?php

namespace App\MessageApi;

use SplObjectStorage;

class MessagesCollection extends SplObjectStorage
{

    function getOwnerId(int $id): self
    {
        $collection = new MessagesCollection;
        foreach ($this as $item) {
            if ($item->ownerId === $id) {
                $collection->attach($item);
            }
        }

        return $collection;
    }

    function getTenantId(int $id): self
    {
        $collection = new MessagesCollection;
        foreach ($this as $item) {
            if ($item->tenantId === $id) {
                $collection->attach($item);
            }
        }

        return $collection;
    }

    function getMessageId(int $id): self
    {
        $collection = new MessagesCollection;
        foreach ($this as $item) {
            if ($item->id === $id) {
                $collection->attach($item);
            }
        }

        return $collection;
    }
}

class MessageDto
{
    public int $id;
    public string $message = '';
    public int $ownerId = 0;
    public int $tenantId = 0;
}

class MessagesParserFactory
{
    function getInstance(string $parser): MessagesParserInterface
    {
        $class = MessagesParserInterface::PARSERS[$parser];
        if (class_exists($class)) {
            return new $class;
        } else {
            throw new \Exception('class not exist' . $class);
        }

    }
}

interface MessagesParserInterface
{

    const JSON = JsonParser::class;
    const XML = XmlParser::class;
    const PARSERS = ['json' => self::JSON, 'xml' => self::XML];

    function getMessages(string $messages): MessagesCollection;
}

class JsonParser implements MessagesParserInterface
{
    function getMessages(string $messages): MessagesCollection
    {

        $messagesArray = json_decode($messages, true);
        $collection = new MessagesCollection();

        foreach ($messagesArray['messages'] as $index => $item) {
            $dto = new MessageDto;
            $dto->id = $index;
            $dto->message = $item['message'] ?? '';
            $dto->ownerId = $item['ownerId'] ?? 0;
            $dto->tenantId = $item['tenantId'] ?? 0;
            $collection->attach($dto);
        }

        return $collection;
    }
}

class XmlParser implements MessagesParserInterface
{
    function getMessages(string $messages): MessagesCollection
    {

    }
}

class ClientApi
{

    public function sendRequest(RequestApi $request): MessagesCollection
    {
        $arrayUrl = explode('/', $request->getUri());
        $parser = end($arrayUrl);
        $factory = (new MessagesParserFactory)->getInstance($parser);
        $messages = $factory->getMessages($this->getBody());

        return $messages;
    }

    function getBody()
    {
        return '{
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
    }

    function getResponse(): MessagesCollection
    {

        $arrayUrl = explode('/', $this->getUrl());
        $parser = end($arrayUrl);
        $factory = (new MessagesParserFactory)->getInstance($parser);
        $messages = $factory->getMessages($this->getBody());

        return $messages;
    }
}

class RequestApi
{
    private string $method;
    private string $uri;

    /**
     * RequestApi constructor.
     * @param string $method
     * @param string $uri
     */
    public function __construct(string $method, string $uri)
    {
        $this->method = $method;
        $this->uri = $uri;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function withMethod($method)
    {
        $this->method = $method;
    }

    public function getUri()
    {
        return $this->uri;
    }
}

$request = new RequestApi('GET', 'domain.com/api/conversation/1200/json');
$client = new ClientApi();
$messages = $client->sendRequest($request);

$ownerId = 2546;
$tenantId = 1505;
echo sprintf("J'ai %d messages au total ." . PHP_EOL, $messages->count());
echo sprintf("Le propriétaire  %d avec %d messages au total ." . PHP_EOL, $ownerId, $messages->getOwnerId($ownerId)->count());
echo sprintf("Le locataire  %d avec %d messages au total ." . PHP_EOL, $tenantId, $messages->getTenantId($tenantId)->count());
echo sprintf("Message 48  %s ." . PHP_EOL, $messages->getMessageId(48)->current()->message);
var_dump($messages);

