<?php

namespace ZendMobileMashup;

use Zend\Http\Client as HttpClient;

class Facebook
{
    const BASE_URL = 'https://graph.facebook.com';

    protected $accessToken;
    protected $appId;
    protected $appSecret;
    protected $httpClient;

    public function __construct(
        HttpClient $httpClient,
        $appId,
        $appSecret
    ) {
        $this->httpClient = $httpClient;
        $this->appId      = $appId;
        $this->appSecret  = $appSecret;
    }

    public function fetchPage($pageId)
    {
        $accessToken = $this->getAccessToken();

        $url = sprintf('%s/%s/feed', self::BASE_URL, $pageId);
        $this->httpClient->resetParameters(true);
        $this->httpClient->setUri($url);
        $this->httpClient->setParameterGet(array(
            'access_token' => $accessToken,
            'fields'       => 'link,from,updated_time,message,story',
        ));
        $response = $this->httpClient->send();
        if (!$response->isSuccess()) {
            throw new \Exception('Failed to retrieve page!');
        }

        $content = $response->getBody();
        $content = trim($content);
        $content = json_decode($content, true);

        // Not caring about pagination, only first page of results
        $data    = $content['data'];
        return $data;
    }

    protected function getAccessToken()
    {
        if ($this->accessToken) {
            return $this->accessToken;
        }

        $url = sprintf('%s/oauth/access_token', self::BASE_URL);
        $this->httpClient->resetParameters(true);
        $this->httpClient->setUri($url);
        $this->httpClient->setParameterGet(array(
            'grant_type'    => 'client_credentials',
            'client_id'     => $this->appId,
            'client_secret' => $this->appSecret,
        ));
        $response = $this->httpClient->send();
        if (!$response->isSuccess()) {
            throw new \Exception('Could not authenticate!');
        }

        $content = $response->getBody();
        $content = trim($content);
        parse_str($content, $params);
        if (!isset($params['access_token'])) {
            throw new \Exception('Authentication error - no access token returned');
        }

        $this->accessToken = $params['access_token'];
        return $this->accessToken;
    }
}
