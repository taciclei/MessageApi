<?php

namespace App\Client;

interface RequestApiInterface
{
    /**
     * @return string
     */
    public function getMethod();

    /**
     * @param string $method
     * @return RequestApi
     */
    public function setMethod($method);

    /**
     * @return string
     */
    public function getUri();

    /**
     * @param string $uri
     * @return RequestApi
     */
    public function setUri($uri);

    public function getParser();
}