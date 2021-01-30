<?php

namespace App\Lib\Wablas;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\RequestOptions;

class WablasClient {
    
    protected $wablasEndpoint;
    protected $apiToken;
    protected $recipients = [];
    protected $httpClient;
    protected $headers;

    public function __construct($apiToken = null) {
        $this->apiToken = $apiToken ?? webOption()->get('wablas_token');
        $this->wablasEndpoint = webOption()->get('wablas_server') ?? 'https://teras.wablas.com/';
        $this->headers = [
            'Accept' => 'application/json',
            'Authorization' => $this->apiToken,
        ];

        $this->httpClient = new GuzzleClient([
            'base_uri' => $this->wablasEndpoint
        ]);

    }

    public function addRecipient($phoneNumber) {
        $this->recipients[] = $phoneNumber;
    }

    public function sendMessage($message, $type = 'random') {
        if (!empty($this->recipients)) {
            $res = $this->httpClient->post('/api/send-message', [
                RequestOptions::HEADERS => $this->headers,
                RequestOptions::FORM_PARAMS => [
                    'phone'     => implode(", ", $this->recipients),
                    'message'   => $message,
                    'type'      => $type
                ],
            ]); 

            return (string) $res->getBody();
        }
       

        return false;
    }

    public function sendImage($imageCaption, $imageUrl) {
        if (!empty($this->recipients)) {
            $res = $this->httpClient->post('/send-image', [
                RequestOptions::HEADERS => $this->headers,
                RequestOptions::FORM_PARAMS => [
                    'phone'     => implode(", ", $this->recipients),
                    'caption'   => $imageCaption,
                    'image'     => $imageUrl,
                    // 'type'      => $type
                ],
            ]); 
        }
    }

}