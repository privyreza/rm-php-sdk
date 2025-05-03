<?php
namespace Resellme;

use GuzzleHttp\Client as HttpClient;
use Resellme\Utils\RequestHandler;
use Resellme\Resources\Domain;
use Resellme\Resources\Hosting;
use Resellme\Resources\VPS;
use Resellme\Resources\Contact;
use Resellme\Resources\Nameserver;

class Client
{
    protected $httpClient;
    protected $requestHandler;

    public function __construct($token, $host = 'https://api.resellme.co.zw', $apiVersion = 'v1')
    {
        $this->httpClient = new HttpClient(['base_uri' => $host . '/api/' . $apiVersion]);
        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/vnd.api+json',
            'Content-Type' => 'application/vnd.api+json',
        ];
        $this->requestHandler = new RequestHandler($this->httpClient, $headers);
    }

    public function domain()
    {
        return new Domain($this->requestHandler);
    }

    public function hosting()
    {
        return new Hosting($this->requestHandler);
    }

    public function vps()
    {
        return new VPS($this->requestHandler);
    }

    public function contact()
    {
        return new Contact($this->requestHandler);
    }

    public function nameserver()
    {
        return new Nameserver($this->requestHandler);
    }
}