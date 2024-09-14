<?php

namespace Tests;

use Illuminate\Foundation\Testing\WithFaker;

abstract class ApiTestCase extends TestCase
{
    use WithFaker;

    /**
     * prefix will be add to all routes
     * 
     * @var string
     */
    protected $apiPrefix = '';

    /**
     * Visit the uri with the a GET request
     * 
     * @param string $uri
     * @param string $headers
     * @return \Illuminate\Testing\TestResponse
     */
    public function get($uri, array $headers = [])
    {
        return parent::getJson($uri, $headers);
    }

    /**
     * Visit the uri with the a POST request
     * 
     * @param string $uri
     * @param string $headers
     * @return \Illuminate\Testing\TestResponse
     */
    public function post($uri, array $data = [], array $headers = [])
    {
        return parent::postJson($uri, $data, $headers);
    }

    /**
     * prepare the given uri
     * 
     * @param string $uri
     * @return string
     */
    protected function prepareUri($uri)
    {
        return $this->apiPrefix . '/' . ltrim($uri, '/');
    }

    /**
     * Call the given URI and return the Response.
     *
     * @param  string  $method
     * @param  string  $uri
     * @param  array  $parameters
     * @param  array  $cookies
     * @param  array  $files
     * @param  array  $server
     * @param  string|null  $content
     * @return \Illuminate\Testing\TestResponse
     */
    public function call($method, $uri, $parameters = [], $cookies = [], $files = [], $server = [], $content = null)
    {
        $uri = $this->prepareUri($uri);

        return parent::call($method, $uri, $parameters, $cookies, $files, $server, $content);
    }


}