<?php

namespace Rdj\Rajaongkir;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

class Rajaongkir
{
    /**
     * The GuzzleHttp Client instance.
     *
     * @var \GuzzleHttp\Client
     */
    protected $http;

    /**
     * The Endpoint instance.
     *
     * @var string
     */
    protected $endpoint;

    /**
     * The Endpoint instance.
     *
     * @var string
     */
    protected $uri;

    /**
     * The Endpoint instance.
     *
     * @var string
     */

    protected $base;
    
    

    /**
     * The headers that will be sent when call the API.
     *
     * @var array
     */
    protected $headers = [];

    /**
     * The body that will be sent when call the API.
     *
     * @var mixed
     */
    protected $body;

    /**
     * The query that will be sent when call the API.
     *
     * @var array
     */
    protected $query = [];

     /**
     * Create a new Class instance.
     *
     * @param  \GuzzleHttp\Client  $http
     * @return void
     */
    public function __construct(HttpClient $http)
    {
        $this->http = $http;

        $this->headers = $this->headers();
        if(env("RAJAONGKIR_TYPE") == "starter" or env("RAJAONGKIR_TYPE") == "basic" ){
            $this->uri = config('rajaongkir_api.uri_starter_basic');
        }else{
            $this->uri = config('rajaongkir_api.uri_pro');
        }
    }

    /**
     * The headers that will be sent when call the API.
     *
     * @var array
     */
    public function headers()
    {
        return $this->headers = [
            'key'   => config('rajaongkir_api.key'),
        ];
    }

    /**
     * The headers that will be sent when call the API.
     *
     * @var array
     */
    public function uri()
    {
        return $this->uri . $this->base . $this->endpoint;
    }

    /**
     * The headers that will be sent when call the API.
     *
     * @var string
     */
    public function setBase($base)
    {
        if($base == "starter"){
            $this->base = 'starter/';    
        }else if($base == "basic"){
            $this->base = 'basic/';
        }else{
            $this->base = 'api/';
        }

        return $this;
    }

    /**
     * Set request endpoint.
     *
     * @param  \GuzzleHttp\Client  $http
     * @return App\RestMiddleware\Client
     */
    public function setEndpoint($endpoint = '')
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    /**
     * Set header for request.
     *
     * @param  array  $headers
     * @return App\RestMiddleware\Client
     */
    public function setHeaders(array $headers)
    {
        $this->headers = array_merge($this->headers(), $headers);

        return $this;
    }

    /**
     * Set body for request.
     *
     * @param  mixed  $body
     * @return App\RestMiddleware\Client
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Set body for request.
     *
     * @param  array  $query
     * @return App\RestMiddleware\Client
     */
    public function setQuery(array $query)
    {
        $this->query = http_build_query($query);

        return $this;
    }

    /**
     * Get for method.
     *
     * @param  string  $query
     * @return App\RestMiddleware\Client
     */
    public function setMethod($method)
    {
        switch ($method) {
            case 'multipart':
                $methods = ['method' => 'POST', 'more_content' => [['name' => '_method', 'contents' => 'put']]];
                break;
            default:
                $methods = ['method' => 'PUT'];
                break;
        }

        return $methods;
    }

    /**
     * Get request from middleware.
     *
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        try {
            $request  = $this->http->request('GET', $this->uri(), [
                'headers'  => $this->headers,
                'query'    => $this->query
            ]);
            $response = json_decode($request->getBody(), true);
        } catch (ClientException $e) {
            $body = $e->getResponse()->getBody();
            $response = json_decode($body->getContents(), true);
        } catch (ServerException $e) {
            abort(500);
        }

        return $response;
    }

    /**
     * Post request to middleware.
     *
     * @return \Illuminate\Http\Response
     */
    public function post($type = 'json')
    {
        try {
            $request  = $this->http->request('POST', $this->uri(), [
                'headers'  => $this->headers,
                'query'    => $this->query,
                $type      => $this->body
            ]);
            $response = json_decode($request->getBody(), true);
        } catch (ClientException $e) {
            $body = $e->getResponse()->getBody();
            $response = json_decode($body->getContents(), true);
        } catch (ServerException $e) {
            \Log::info($e->getRequest()->getBody());
            abort(500);
        }

        return $response;
    }

    /**
     * Post request to middleware.
     *
     * @return \Illuminate\Http\Response
     */
    public function put($type = 'json')
    {
        $method = $this->setMethod($type);
        $body = array_key_exists('more_content', $method) ? array_merge($this->body, $method['more_content']) : $this->body;

        try {
            $request  = $this->http->request($method['method'], $this->uri(), [
                'headers'  => $this->headers,
                'query'    => $this->query,
                $type      => $body
            ]);
            $response = json_decode($request->getBody(), true);
        } catch (ClientException $e) {
            $body = $e->getResponse()->getBody();
            $response = json_decode($body->getContents(), true);
        } catch (ServerException $e) {
            abort(500);
        }

        return $response;
    }

    /**
     * Delete request to middleware.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleted()
    {
        try {
            $request  = $this->http->request('DELETE', $this->uri(), [
                'headers'  => $this->headers,
                'query'    => $this->query,
                'json'     => $this->body
            ]);
            $response = json_decode($request->getBody(), true);
        } catch (ClientException $e) {
            $body = $e->getResponse()->getBody();
            $response = json_decode($body->getContents(), true);
        } catch (ServerException $e) {
            abort(500);
        }

        return $response;
    }
}