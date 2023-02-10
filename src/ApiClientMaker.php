<?php

namespace LT\Utils\ApiClientMaker;

use Symfony\Component\HttpClient\HttpClient;

class ApiClientMaker
{
    public $authServiceUrl;
    public $authServiceUser;
    public $authServicePassword;
    public function __construct($authServiceUrl, $authServiceUser, $authServicePassword)
    {
        $this->authServiceUrl = $authServiceUrl;
        $this->authServiceUser = $authServiceUser;
        $this->authServicePassword = $authServicePassword;
    }

    public function getClient()
    {
        $client = HttpClient::create();
        $options = [
            'json' => [
                "username" => $this->authServiceUser,
                "password" => $this->authServicePassword,
            ]
        ];
        $response = $client->request('POST', $this->authServiceUrl, $options);

        $statusCode = $response->getStatusCode();
        if ($statusCode != 200) {
            throw \Exception('Auth Service Refused With Status Code Of:' . $statusCode . "\r\nResponded With:" . print_r($response->getContent(), true));
        }

        $responseData = $response->toArray();
        if (!isset($responseData['token'])) {
            throw \Exception('Could Not Get Auth Token From:' . print_r($responseData, true));
        }

        return HttpClient::create([
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'auth_bearer' => $responseData['token'],
        ]);
    }
}