<?php


namespace App\Message;

class MessageDto
{
    public int $id;
    public string $message = '';
    public int $ownerId = 0;
    public int $tenantId = 0;
}