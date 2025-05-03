<?php
namespace Resellme\Resources;

use GuzzleHttp\Client;

class Hosting
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
        $response = $this->client->post('/hostings', [
            'headers' => $this->headers,
            'json' => $data,
        ]);

        return json_decode($response->getBody(), true);
    }

    public function provision($hostingId)
    {
        $response = $this->client->post("/hostings/{$hostingId}/provision", [
            'headers' => $this->headers,
        ]);

        return json_decode($response->getBody(), true);
    }

    public function list()
    {
        $response = $this->client->get('/hostings', [
            'headers' => $this->headers,
        ]);

        return json_decode($response->getBody(), true);
    }

    public function get($hostingId)
    {
        $response = $this->client->get("/hostings/{$hostingId}", [
            'headers' => $this->headers,
        ]);

        return json_decode($response->getBody(), true);
    }

    public function update($hostingId, $data)
    {
        $response = $this->client->patch("/hostings/{$hostingId}", [
            'headers' => $this->headers,
            'json' => $data,
        ]);

        return json_decode($response->getBody(), true);
    }

    public function suspend($hostingId)
    {
        $response = $this->client->post("/hostings/{$hostingId}/suspend", [
            'headers' => $this->headers,
        ]);

        return json_decode($response->getBody(), true);
    }

    public function unsuspend($hostingId)
    {
        $response = $this->client->post("/hostings/{$hostingId}/unsuspend", [
            'headers' => $this->headers,
        ]);

        return json_decode($response->getBody(), true);
    }

    public function terminate($hostingId)
    {
        $response = $this->client->delete("/hostings/{$hostingId}", [
            'headers' => $this->headers,
        ]);

        return json_decode($response->getBody(), true);
    }
}