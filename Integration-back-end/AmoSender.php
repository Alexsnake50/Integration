<?php

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client as Http;
use Predis\Client;

class AmoSender
{
    private array $body;

    public function __construct(array $body){
        $this->body = $body;
        $this->http = new Http();
    }

    public function handle(){
        $contactId=$this->createContact();
        $this->createLead($contactId);
    }

    private function createContact(){
        $contactBody =  [
            [
                "name" => $this->body['name'],
                "custom_fields_values" => [
                    [
                        "field_code" => "EMAIL",
                        "values" => [
                            [
                                "enum_code" => "WORK",
                                "value" => $this->body['email']
                            ]
                        ]
                    ],
                    [
                        "field_code" => "PHONE",
                        "values" => [
                            [
                                "enum_code" => "WORK",
                                "value" => $this->body['phone']
                            ]
                        ]
                    ]
                ]
            ]
        ];
        $response = $this->send($contactBody,'api/v4/contacts');
        return $response['_embedded']['contacts'][0]['id'];
    }

    private function createLead(int $contactId){
        $leadBody =  [
            [
                "name" => $this->body['name'],
                "price" => intval($this->body['price']),
                "_embedded" => [
                    "contacts" => [
                        [
                            "id" => $contactId
                        ]
                    ]
                ]
            ]
        ];
        $this->send($leadBody,'api/v4/leads');
    }

    private function send(array $Data, string $urn){
        $options = [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '.ACCESS_TOKEN
            ],
            'json' => $Data
        ];
        try {
            $response = $this->http->request('POST', HOST.$urn, $options);
            return json_decode($response->getBody()->getContents(),true);
        } catch (ClientException $e) {
            echo $e;
        }
    }
}