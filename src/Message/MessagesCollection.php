<?php

namespace App\Message;

class MessagesCollection extends \SplObjectStorage
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