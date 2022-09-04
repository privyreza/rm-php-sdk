<?php
namespace Resellme;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Resellme\Hosting;

class Client
{
    /**
     * The client for making http calls to api
     */
    protected $client;

    /**
     *  The API host URL
     * 
     */
    protected $host;

    /**
     * Api Url 
     */
    protected $apiUrl;

    /**
     * The API version to connect to
     */
    protected $apiVersion;

    /**
     * token
     */
    protected $token;

    /**
     * Request headers
     */
    protected $headers;

    /**
     * Set env
     */
    protected $debug;

    /**
     * Initialize the client
     */
    public function __construct($token){
        $this->host = 'https://api.resellme.co.zw';
        $this->apiVersion = 'v1';
        $this->apiUrl = $this->host . '/api/' . $this->apiVersion;
        // $this->debug = getenv('DEBUG');

        $this->client = new \GuzzleHttp\Client(
            [
                "base_uri" => $this->host
            ]
        );

        // Set Headers
        $this->headers = [
            "Accept" => "application/vnd.api+json",
            "Content-Type" => "application/vnd.api+json",
            'Authorization' => 'Bearer ' . $token
        ];
    }

    /**
     * Search domain
     * @return Object
     */
     public function searchDomain($domain) {
        $url = $this->host . '/api/v1/searches';
        $options = [
            "json" => [
                "domain" => $domain
            ],
            "headers" => $this->headers,
            "http_errors" => false
        ];

        $response = $this->client->post(
            $url,
            $options
        );

        return json_decode((string) $response->getBody());
    }

     /**
     * Create new Contact
     */
    public function createContact($contact = []){
        return $this->_post('contacts', $contact);
    }

    /**
     * Create new NS
     */
    public function createNS($ns){
        return $this->_post('nameservers', $ns);
    }

    /**
     * Create Domain
     */
    public function createDomain($data){
        return $this->_post('domains', $data);
    }

    /**
     * Register Domain
     */
    public function registerDomain($data){
        // Check if domain does not exist first
        $domain = null;
        $domain_name = $data['domain'];
        $domainFilter = [
            'name' => $domain_name
        ];
        
        $remoteDomain = $this->_get('domains', '', $domainFilter)->data;

        if (!empty($remoteDomain)) {
            $domain = $remoteDomain[0];
        }
        
        if (is_null($domain)){
             // Create Domain
            $domainData = [
                "name" => $data['domain'],
                "status" => "pending"
            ];
            $domain = $this->createDomain($domainData)->data;
    
            // Create Contact
            $contact_data = array_merge($data['contacts']['registrant'], ['domain_id' => $domain->id]);
            $contact = $this->createContact($contact_data);
    
            // Create NS
            $ns_data = array_merge($data['nameservers'], ['domain_id' => $domain->id]);
            $ns = $this->createNS($ns_data);
        }
        
        $domain_id = $domain->id;
        
        $domainStatus = $domain->attributes->status;
        
        if ($domainStatus !== 'registered'){
            // Submit the domain for registration
            $registrationLink = 'domains/' . $domain_id . '/register';
            return $this->_post($registrationLink, $data);
        } else {
            throw new \Exception('ERR66 : Domain already registered');
        }
    }

    /**
     * Transfer Domain
     */
    public function transferDomain($data){
        // Check if domain does not exist first
        $domain = null;
        $domain_name = $data['domain'];
        $domainFilter = [
            'name' => $domain_name
        ];
        
        $remoteDomain = $this->_get('domains', '', $domainFilter)->data;

        if (!empty($remoteDomain)) {
            $domain = $remoteDomain[0];
        }
        
        if ( is_null($domain) ){
             // Create Domain
            $domainData = [
                "name" => $data['domain'],
                "status" => "pending"
            ];
            $domain = $this->createDomain($domainData)->data;
    
            // Create Contact
            $contact_data = array_merge($data['contacts']['registrant'], ['domain_id' => $domain->id]);
            $contact = $this->createContact($contact_data);
    
            // Create NS
            $ns_data = array_merge($data['nameservers'], ['domain_id' => $domain->id]);
            $ns = $this->createNS($ns_data);
        }
        
        $domain_id = $domain->id;
        
        $domainStatus = $domain->attributes->status;
        
        if ($domainStatus !== 'transferred'){
            // Submit the domain for registration
            $transferLink = 'domains/' . $domain_id . '/transfer';
            return $this->_post($transferLink, $data);
        } else {
            throw new \Exception('ERR67 : Domain already transferred');
        }
    }
    
    /**
     * Renew Domain
     */
    public function renewDomain($data){
        // Check if domain does not exist first
        $domain = null;
        $domain_name = $data['domain'];
        $domainFilter = [
            'name' => $domain_name
        ];
        
        $remoteDomain = $this->_get('domains', '', $domainFilter)->data;

        if (!empty($remoteDomain)) {
            $domain = $remoteDomain[0];
        }
        
        if ( is_null($domain) ){
            throw new \Exception('ERR110 : Domain does not exist');
        }
        
        $domain_id = $domain->id;
        
        $domainStatus = $domain->attributes->status;
        
        $renewLink = 'domains/' . $domain_id . '/renew';

        $data = [];
        
        return $this->_post($renewLink, $data);
    }
    
    public function getDomainInfo($data){
        $domain_name = $data['domain']['name'];
        $domainFilter = [
            'name' => $domain_name
        ];
        
        $domain = $this->_get('domains', '', $domainFilter)->data[0]->attributes;
        
        print_r($domain);
        
        die();
        
        if( is_null ( $domain )){
            // Create domain if it does not exist : TOREMOVE
            $domainData = [
                'domain' => $domain_name,
                'status' => 'registered',
                'registration_date' => $data['domain']['registration_date'],
                'expiration_date' => $data['domain']['expiration_date']
            ];
            
            
            $domain = $this->createDomain($domainData);
            $domain_id = $domain->data->id;
            
            // Create Contact
            $contact_data = array_merge($data['contacts']['registrant'], ['domain_id' => $domain_id]);
            $contact = $this->createContact($contact_data);
    
            // Create NS
            $ns_data = array_merge($data['nameservers'], ['domain_id' => $domain_id]);
            $ns = $this->createNS($ns_data);
            
            return $domain->data->attributes;
        } else {
            return $domain;
        }
    }

    public function getWhoisInformation($postData){
        $domainFilter = [
           'name' => $postData['domain']
       ];
       
       $domain_id = $this->getDomainId($domainFilter);
       
       $contactsFilters = [
           "domain_id" => $domain_id
       ];
       
       $contacts =  $this->_get('contacts', "", $contactsFilters)->data[0]->attributes;
      
       return $contacts;
   }
    
    public function getNameservers($postData){
         $domainFilter = [
            'name' => $postData['domain']
        ];
        
        $domain_id = $this->getDomainId($domainFilter);
        
        $nameserversFilters = [
            "domain_id" => $domain_id
        ];
        
        $ns =  $this->_get('nameservers', "", $nameserversFilters)->data[0]->attributes;
       
        return $ns;
    }

    /**
     * Get Domains
     *
     */
     public function getDomains($filters){
        $domains = [];
        $response =  $this->_get('domains', "", $filters);

        if ( ! empty( $domains )) {
            foreach ($domains as $key => $domain) {
                array_push($domains, $domain->attributes);
            }
        }
       
        return $domains;
    }
    
    protected function getDomainId($domain){
        return $this->_get("domains", "", $domain)->data[0]->id;
    }
    
    public function setNameservers($postData){
        $domainFilter = [
            'name' => $postData['domain']
        ];
        
        $domain_id = $this->getDomainId($domainFilter);
        
        $nameserversFilters = [
            "domain_id" => $domain_id
        ];
        
        $nsId = $this->_get("nameservers", "", $nameserversFilters)->data[0]->id;
        
        return $this->_patch('nameservers', $nsId, $postData['nameservers']);
    }

    public function updateWhoisInformation($data){
        $domainFilter = [
            'name' => $data['domain']
        ];
        
        $domain_id = $this->getDomainId($domainFilter);
        

        // Get Contact
        $contactsFilter = [
            "domain_id" => $domain_id
        ];

        $contantId = $this->_get('contacts', '', $contactsFilter)->data[0]->id;
        $registrant = $this->_patch('contacts', $contantId, $data['contacts']['registrant']);
        
        // // Get registrant
        // $registrantFilter = [
        //     "contact_id" => $contantId
        // ];

        // $registrantId = $this->_get('registrants', '', $registrantFilter)->data[0]->id;

        // // Update registrant
        // $registrant = $this->_patch('registrants', $registrantId, $data['contacts']['registrant']);

        // // Get tech contact
        // $techFilter = [
        //     "contact_id" => $contantId
        // ];

        // $techId = $this->_get('techs', '', $techFilter)->data[0]->id;

        // // Update Tech Contact
        // $tech = $this->_patch('techs', $techId, $data['contacts']['tech']);

        return [
            'contacts' => [
                'registrant' => $registrant,
                // 'tech' => $tech
            ]
        ];
    }

    /**
     * Login to API
     */
    public function authorize(){
        // $password = getenv('PASSWORD');
        // $email = getenv('EMAIL');
        $client_id = getenv('CLIENT_ID');
        $secret = getenv('SECRET');

        $options = [
            'form_params' =>  [
                "grant_type" => "client_credentials",
                "client_id" => $client_id,
                "client_secret" => $secret
            ]
        ];

        try
        {
            $response = $this->client->post('/oauth/token', $options);

            $responseString = (string) $response->getBody();

            $responseArray = json_decode($responseString);

            $this->token = $responseArray->access_token;
        } 
        catch(\Exception $ex){
            // echo $ex->getMessage();
            $error = [
                "errors" => [
                    [
                        "status" => "401",
                        "title" => "Failed to login"
                    ]
                ]
            ];
            
            return json_encode($error);
        }
    }

    protected function _get($resource, $record = "", $filters = []){
        $options = [
            "headers" => $this->headers,
            "http_errors" => false,
            'timeout' => 2000
        ];
        
        $url = $this->apiUrl . '/' . $resource;
        
        if( ! empty($record)){
            $url .= "/" . $record;
        } elseif ( ! empty ($filters) ) {
            $url .= "?";
            
            foreach ( $filters as $key => $filter ) {
                $url .= "filter[$key]=$filter&";
            }
        }
        
        $response = $this->client->get($url, $options);

        $code = $response->getStatusCode();

        if ($code == '200' || $code == '201') {
            return json_decode( ( string ) $response->getBody());
        } else {
            throw new \Exception('Error fetching data. ' . ( string ) $response->getBody());
        }
    }

    protected function _post($resource, $data){
        $url = $this->apiUrl . '/' . $resource;

        $options = [
            "json" => [
                "data" => [
                    "type" => $resource,
                    "attributes" => $data
                ]
            ],
            "headers" => $this->headers,
            "http_errors" => false
        ];

        $response = $this->client->post(
            $url, 
            $options
        );

        $code = $response->getStatusCode();

        if ($code == '200' || $code == '201') {
            return json_decode( ( string ) $response->getBody());
        } else {
            throw new \Exception('Error posting data. ' . ( string ) $response->getBody());
        }
    }

    protected function _patch($resource, $record, $data){
        $url = $this->apiUrl . '/' . $resource . '/' . $record;

        $options = [
            "json" => [
                "data" => [
                    "type" => $resource,
                    "id" => "$record",
                    "attributes" => $data
                ]
            ],
            "headers" => $this->headers,
             "http_errors" => false
        ];
        
        $response = $this->client->patch(
            $url, 
            $options
        );
        
        $code = $response->getStatusCode();

        if ($code == '200' || $code == '201') {
            return json_decode( ( string ) $response->getBody());
        } else {
            throw new \Exception('Error updating data. ' . ( string ) $response->getBody());
        }
    }

    public function createHosting($data) {
        return $this->_post('hostings', $data);
    }

    public function provisionHosting($data) {
        try {
            $hosting = null;
            $domain_name = $data['domain'];
            $hostingFilter = [
                'name' => $domain_name
            ];

            $remoteHosting = $this->_get('hostings', '', $hostingFilter)->data;

            if (!empty($remoteHosting)) {
                $hosting = $remoteHosting[0];
            } else {
                $domainData = [
                    'billing_cycle_id' => 1,
                    'package_id' => 1,
                    'domain' => $domain_name,
                ];
                
                $hosting = $this->createHosting($domainData)->data;
            }

            $hostingProvisionLink = 'hostings/' . $hosting->id . '/provision';
            $data = [];

            return $this->_post($hostingProvisionLink, $data);

        } catch (\Exception $e) {
            throw new \Exception('Error creating hosting service. Error: ' . $e->getMessage());
        }
    }
}

