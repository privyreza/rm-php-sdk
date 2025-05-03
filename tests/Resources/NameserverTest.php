<?php
use PHPUnit\Framework\TestCase;
use Resellme\Client;
use Resellme\Resources\Nameserver;

class NameserverTest extends TestCase
{
    public function testListNameservers()
    {
        $client = new Client('test-token');
        $nameserver = $client->nameserver();
        $this->assertInstanceOf(Nameserver::class, $nameserver);

        // Mock response and test list method
        $response = $nameserver->list('domain-id');
        $this->assertIsArray($response);
    }

    public function testUpdateNameservers()
    {
        $client = new Client('test-token');
        $nameserver = $client->nameserver();

        $response = $nameserver->update('domain-id', ['ns1.example.com', 'ns2.example.com']);
        $this->assertIsArray($response);
    }

    public function testAddNameserver()
    {
        $client = new Client('test-token');
        $nameserver = $client->nameserver();

        $response = $nameserver->add('domain-id', 'ns3.example.com');
        $this->assertIsArray($response);
    }

    public function testDeleteNameserver()
    {
        $client = new Client('test-token');
        $nameserver = $client->nameserver();

        $response = $nameserver->delete('domain-id', 'ns3.example.com');
        $this->assertIsArray($response);
    }
}