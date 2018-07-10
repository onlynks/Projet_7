<?php

namespace AppBundle\Service;

use GuzzleHttp\Client;

class CodeManager
{
    private $apiId;
    private $apiKey;

    public function __construct($apiId, $apiKey)
    {
        $this->apiId = $apiId;
        $this->apiKey = $apiKey;
    }

    public function seekToken($code, $url)
    {
        $client = new Client([
            'base_uri'=>'https://graph.facebook.com/v3.0/oauth/access_token?'
        ]);

        $query = $client->request('GET', null, [
            'query'=>[
                'client_id'=>$this->apiId,
                'redirect_uri'=>$url,
                'client_secret'=>$this->apiKey,
                'code'=>$code
            ]
        ]);

        return $query->getBody()->getContents();
    }
}
