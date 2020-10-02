<?php
namespace App\Client;

class RequestApi implements RequestApiInterface
{
    /**
     * @var string
     */
    public $method;
    /**
     * @var string
     */
    public $uri;

    /**
     * @var string
     */
    public $parser;

    /**
     * RequestApi constructor.
     * @param string $method
     * @param string $uri
     */
    public function __construct(string $method, string $uri)
    {
        $this->method = $method;
        $this->uri = $uri;
        $arrayUrl = explode('/', $this->getUri());
        $this->parser = end($arrayUrl);
    }

    public function getParser() {
        return $this->parser;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $method
     * @return RequestApi
     */
    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param string $uri
     * @return RequestApi
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
        return $this;
    }
}