<?php
namespace Resellme\Utils;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Resellme\Exceptions\ApiException;
use Resellme\Exceptions\ServerException as ResellmeServerException;

class RequestHandler
{
    protected $client;
    protected $headers;

    public function __construct(Client $client, array $headers)
    {
        $this->client = $client;
        $this->headers = $headers;
    }

    public function request($method, $uri, $options = [])
    {
        try {
            $options['headers'] = $this->headers;
            $response = $this->client->request($method, $uri, $options);

            return json_decode($response->getBody(), true);
        } catch (ClientException $e) {
            // Handle 4xx errors
            throw new ApiException('Client error: ' . $e->getMessage(), $e->getCode(), $e);
        } catch (ServerException $e) {
            // Handle 5xx errors
            throw new ResellmeServerException('Server error: ' . $e->getMessage(), $e->getCode(), $e);
        } catch (\Exception $e) {
            // Handle other errors
            throw new ApiException('Unexpected error: ' . $e->getMessage(), $e->getCode(), $e);
        }
    }
}