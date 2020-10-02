<?php

namespace App\Message\Parser;

use App\Message\MessagesCollection;
use App\Message\MessageDto;

class JsonParser implements MessagesParserInterface
{
    /**
     * @param string $messages
     * @return MessagesCollection
     */
    public function getMessages(string $messages): MessagesCollection
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