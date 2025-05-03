<?php
namespace Resellme\Resources;

use Resellme\Utils\RequestHandler;

class Domain
{
    protected $requestHandler;

    public function __construct(RequestHandler $requestHandler)
    {
        $this->requestHandler = $requestHandler;
    }

    public function search($domain)
    {
        return $this->requestHandler->request('POST', '/domains/search', [
            'json' => ['domain' => $domain],
        ]);
    }

    public function register($data)
    {
        return $this->requestHandler->request('POST', '/domains/register', [
            'json' => $data,
        ]);
    }

    public function transfer($data)
    {
        return $this->requestHandler->request('POST', '/domains/transfer', [
            'json' => $data,
        ]);
    }

    public function renew($domainId, $data = [])
    {
        return $this->requestHandler->request('POST', "/domains/{$domainId}/renew", [
            'json' => $data,
        ]);
    }
}