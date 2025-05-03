<?php
use PHPUnit\Framework\TestCase;
use Resellme\Client;

class ClientTest extends TestCase
{
    public function testDomainResource()
    {
        $client = new Client('test-token');
        $domain = $client->domain();
        $this->assertInstanceOf(\Resellme\Resources\Domain::class, $domain);
    }
}