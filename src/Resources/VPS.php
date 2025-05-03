<?php
namespace Resellme\Resources;

use GuzzleHttp\Client;

class VPS
{
    protected $client;
    protected $headers;

    public function __construct(Client $client, array $headers)
    {
        $this->client = $client;
        $this->headers = $headers;
    }

    public function create($data)
    {
        $response = $this->client->post('/vps', [
            'headers' => $this->headers,
            'json' => $data,
        ]);

        return json_decode($response->getBody(), true);
    }

    public function manage($vpsId, $action)
    {
        $response = $this->client->post("/vps/{$vpsId}/actions", [
            'headers' => $this->headers,
            'json' => ['action' => $action],
        ]);

        return json_decode($response->getBody(), true);
    }
}