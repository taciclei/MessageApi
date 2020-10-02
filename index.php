<?php

namespace App;

use App\Client\ClientApiInterface;

require 'vendor/autoload.php';

$app = new Kernel();

$messages = $app->getSevice()->get(ClientApiInterface::class)->getResponse();

$ownerId = 2546;
$tenantId = 1505;
echo sprintf("J'ai %d messages au total ." . PHP_EOL, $messages->count());
echo sprintf("Le propriétaire  %d avec %d messages au total ." . PHP_EOL, $ownerId, $messages->getOwnerId($ownerId)->count());
echo sprintf("Le locataire  %d avec %d messages au total ." . PHP_EOL, $tenantId, $messages->getTenantId($tenantId)->count());
echo sprintf("Message 48  %s ." . PHP_EOL, $messages->getMessageId(48)->current()->message);
dd($messages);

