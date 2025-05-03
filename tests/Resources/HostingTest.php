<?php
use PHPUnit\Framework\TestCase;
use Resellme\Client;
use Resellme\Resources\Hosting;

class HostingTest extends TestCase
{
    public function testListHostings()
    {
        $client = new Client('test-token');
        $hosting = $client->hosting();
        $this->assertInstanceOf(Hosting::class, $hosting);

        $response = $hosting->list();
        $this->assertIsArray($response);
    }

    public function testGetHosting()
    {
        $client = new Client('test-token');
        $hosting = $client->hosting();

        $response = $hosting->get('hosting-id');
        $this->assertIsArray($response);
    }

    public function testUpdateHosting()
    {
        $client = new Client('test-token');
        $hosting = $client->hosting();

        $response = $hosting->update('hosting-id', ['plan' => 'new-plan']);
        $this->assertIsArray($response);
    }

    public function testSuspendHosting()
    {
        $client = new Client('test-token');
        $hosting = $client->hosting();

        $response = $hosting->suspend('hosting-id');
        $this->assertIsArray($response);
    }

    public function testUnsuspendHosting()
    {
        $client = new Client('test-token');
        $hosting = $client->hosting();

        $response = $hosting->unsuspend('hosting-id');
        $this->assertIsArray($response);
    }

    public function testTerminateHosting()
    {
        $client = new Client('test-token');
        $hosting = $client->hosting();

        $response = $hosting->terminate('hosting-id');
        $this->assertIsArray($response);
    }
}