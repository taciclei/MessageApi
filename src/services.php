<?php

namespace App;

use App\Client\ClientApi;
use App\Client\ClientApiInterface;
use App\Client\RequestApi;
use App\Client\RequestApiInterface;
use App\Message\MessageManagerFactory;
use App\Message\Parser\MessagesParserInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return function(ContainerConfigurator $configurator) {

    $services = $configurator->services()
        ->defaults()
        ->autowire()      // Automatically injects dependencies in your services.
        ->autoconfigure() // Automatically registers your services as commands, event subscribers, etc.
    ;

    $services->load('App\\', '../src/')
        ->exclude('../src/{Kernel.php,services.php}');

    $services->set(RequestApiInterface::class, RequestApi::class)
        ->arg('$method', 'GET')
        ->arg('$uri', 'domain.com/api/conversation/1200/json')
    ;

    $services->set(ClientApiInterface::class, ClientApi::class)
        ->args([service(MessagesParserInterface::class)])
        ->call('sendRequest', [service(RequestApiInterface::class)])
        ->public()
    ;

    $services->set(MessagesParserInterface::class)->public()
        ->factory([service(MessageManagerFactory::class), 'createMessageManager'])
        ->arg('$request', service(RequestApiInterface::class))
    ;
};