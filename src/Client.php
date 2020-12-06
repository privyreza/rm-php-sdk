<?php
namespace Resellme;

use Pdr\Client;

class Client
{
    /**
     * The client for making http calls to api
     */
    protected $client;

    /**
     * token
     */
    protected $token;


    /**
     * Initialize the client
     * https://resellme.co.zw/docs/php-sdk
     */
    public function __construct($token){
        $this->token = $token;
        $this->client = new Client($this->token);
    }

    /**
     * Search domain
     * @return Object
     */
    public function searchDomain($domain){
        return $this->client->searchDomain($domain);
    }

     /**
     * Create new Contact
     */
    public function createContact($contact){
        return $this->client->createContact($contact);
    }

    /**
     * Create new NS
     */
    public function createNS($ns){
        return $this->client->createNS($ns);
    }

    /**
     * Create Domain
     */
    public function createDomain($data){
        return $this->client->createDomain($data);
    }

    /**
     * Register Domain
     */
    public function registerDomain($data){
        return $this->client->registerDomain($data);
    }

    public function transferDomain($data){
        return $this->client->transferDomain($data);
    }
    
    public function getDomainInfo($data){
        return $this->client->getDomainInfo($data);
    }

    public function getWhoisInformation($data){
       return $this->client->getWhoisInformation($data);
   }
    
    public function getNameservers($data){
         return $this->client->getNameservers($data);
    }
    
    public function setNameservers($data){
        return $this->client->setNameservers($data);
    }

    public function updateWhoisInformation($data){
        return $this->client->updateWhoisInformation($data);
    }

    public function getDomains($filters = []){
        return $this->client->getDomains($filters);
    }
}

