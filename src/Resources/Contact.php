<?php
namespace Resellme\Resources;

use GuzzleHttp\Client;

class Contact
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
        $response = $this->client->post('/contacts', [
            'headers' => $this->headers,
            'json' => $data,
        ]);

        return json_decode($response->getBody(), true);
    }

    public function update($contactId, $data)
    {
        $response = $this->client->patch("/contacts/{$contactId}", [
            'headers' => $this->headers,
            'json' => $data,
        ]);

        return json_decode($response->getBody(), true);
    }

    public function get($contactId)
    {
        $response = $this->client->get("/contacts/{$contactId}", [
            'headers' => $this->headers,
        ]);

        return json_decode($response->getBody(), true);
    }
}