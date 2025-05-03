<?php
namespace Resellme\Resources;

use GuzzleHttp\Client;

class Nameserver
{
    protected $client;
    protected $headers;

    public function __construct(Client $client, array $headers)
    {
        $this->client = $client;
        $this->headers = $headers;
    }

    public function list($domainId)
    {
        $response = $this->client->get("/domains/{$domainId}/nameservers", [
            'headers' => $this->headers,
        ]);

        return json_decode($response->getBody(), true);
    }

    public function update($domainId, array $nameservers)
    {
        $response = $this->client->put("/domains/{$domainId}/nameservers", [
            'headers' => $this->headers,
            'json' => ['nameservers' => $nameservers],
        ]);

        return json_decode($response->getBody(), true);
    }

    public function add($domainId, $nameserver)
    {
        $response = $this->client->post("/domains/{$domainId}/nameservers", [
            'headers' => $this->headers,
            'json' => ['nameserver' => $nameserver],
        ]);

        return json_decode($response->getBody(), true);
    }

    public function delete($domainId, $nameserver)
    {
        $response = $this->client->delete("/domains/{$domainId}/nameservers", [
            'headers' => $this->headers,
            'json' => ['nameserver' => $nameserver],
        ]);

        return json_decode($response->getBody(), true);
    }
}