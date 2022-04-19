<?php

namespace Explicador\E2PaymentsPhpSdk;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Mpesa
{

    private $base_uri = 'https://e2payments.explicador.co.mz';
    private $client_secret;
    private $client_id;
    private $wallet_id;

    public function __construct($config = null)
    {
        if (is_array($config)) {
            $this->setClientSecret($config['client_secret']);
            $this->setClientId($config['client_id']);
            $this->setWalletId($config['wallet_id']);
        }
    }
    public function setClientSecret($client_secret)
    {
        $this->client_secret = $client_secret;
    }

    public function setClientId($client_id)
    {
        $this->client_id = $client_id;
    }

    public function setWalletId($wallet_id)
    {
        $this->wallet_id = $wallet_id;
    }


    /**
     *  Standard customer-to-business transaction
     *
     * @param $phone
     * @param $amount
     * @param string $reference
     * @return \stdClass
     */
    public function c2b($phone, $amount, $reference = 'Mpesae2Payments')
    {

        $fields = [
            "phone"     => $phone,
            "amount"    => $amount,
            "reference" => $reference,
            "client_id" => $this->client_id,
            "wallet_id" => $this->wallet_id, // TODO: Por remover...
            "fromApp"   => 'e2PaymentsServer',
        ];

        return $this->makeRequest($fields);
    }


    /**
     *  Get Bearer Token from server sending to e2Payments server the 'client_id' and 'client_secret'
     * @return null|string
     *
     */
    public function getToken()
    {

        $client = new Client([
            'base_uri' => $this->base_uri,
            'timeout' => 90,
        ]);
        $options = [
            'http_errors' => false,
            'headers' => [],
            'verify' => false,
            'json' => [
                'grant_type'    => 'client_credentials',
                'client_id'     => $this->client_id,
                'client_secret' => $this->client_secret,
            ]
        ];

        try {

            $res = $client->request('POST', $this->base_uri . '/oauth/token', $options);

            if ($res->getStatusCode() == 200) {

                $responseKeys = json_decode($res->getBody()->getContents());

                $token = $responseKeys->token_type . ' ' . $responseKeys->access_token;

                return $token; //TODO: Retornar aqui o token

            }

            // Something bad happened...

            return null;

        } catch (GuzzleException $e) {

            return null;

        }

    }


    /**
     *  Start a comunication with e2Payments server, passing all the required parameters
     *
     * @param array $fields
     * @return \stdClass
     *
     */
    private function makeRequest(array $fields = [])
    {

        $client = new Client([
            'base_uri' => $this->base_uri,
            'timeout' => 180,
        ]);

        $options = [
            'http_errors' => false,
            'headers' => $this->getHeaders(),
            'verify' => false,
            'json' => $fields
        ];

        $endpoint = $this->base_uri . '/v1/c2b/mpesa-payment/' . $this->wallet_id;

        try {

            $response = $client->request('POST', $endpoint, $options);

            $return = new \stdClass();
            $return->response = json_decode($response->getBody());

            if ($return->response == false) {
                $return->response = $response->getBody();
            }

            $return->status = $response->getStatusCode();

            return $return;

        } catch (GuzzleException $e) {

            $return = new \stdClass();

            $return->response = $e->getMessage();
            $return->status = $e->getCode();

            return $return;

        }
    }

    /**
     * @return array
     */
    private function getHeaders()
    {

        $headers = [
            'Content-Type'  => 'application/json',
            'Authorization' =>  $this->getToken(),
            'Accept'        => 'application/json',
            'Connection'    => 'keep-alive',
            'Origin'        => $this->actualUrl()
        ];
        return $headers;
    }


    private function actualUrl () {
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]"; // TODO: SECURE WAY TO GET THIS...
    }
}
