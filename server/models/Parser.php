<?php

namespace app\models;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Message\MessageFactoryInterface;

class Parser
{
    public static $instance = NULL;
    public $baseUri = NULL;
    public $path = NULL;
    public $method = NULL;
    public $cookies = NULL;
    public $client = NULL;
    public $formParams = NULL;
    public $headers = NULL;

    /**
     * @return type $instance
     */
    public static function init()
    {
        
        if (self::$instance === null) 
            self::$instance = new self();
        
        return self::$instance;
    }

    public function __construct()
    {
        $this->cookies = new CookieJar();
    }

    /**
     * @param type $path
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }
    
    /**
     * @param type $formParams
     */
    public function setFormParams($formParams)
    {
        $this->formParams = $formParams;
        return $this;
    }

    /**
     * @param type $headers
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * @param type $baseUri
     */
    public function setBaseUri($baseUri)
    {   
        $this->baseUri = $baseUri;
        return $this;
    }

    /**
     * @param type $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return type string
     */
    public function execute()
    {
        $client = new Client([
            'cookies' => true,
            'base_uri' => $this->baseUri,
            'timeout'  => 60,
             'headers' => $this->headers
        ]);
        $this->client = $client->request($this->method, $this->path, [
           // 'proxy' => 'http://localhost:8080',
            'debug' => false,
            'verify' => false,
            'cookies' => $this->cookies,
            'http_errors' => false,
            'allow_redirects' => [
                    'max' => 10,        
                    'strict' => true,      
                    'referer' => true,   
                    'track_redirects' => true,
                ],
            'form_params' => $this->formParams,
        ]); 

        return $this;
    }
}
