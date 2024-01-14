<?php

namespace App;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;

class GithubApi
{
    /**
     * Github API base url
     */
    private $baseUrl = 'https://api.github.com/';

    /**
     * cURL headers
     */
    private $headers = [];

    /**
     * guzzle client
     */
    private $client;

    /**
     * Initializes the cURL headers array with the necessary values for making requests to the GitHub API.
     *
     * @return void
     */
    public function __construct()
    {
        $this->client = new Client();
        $this->headers = [
            'Accept' => 'application/vnd.github+json',
            'Authorization' => 'Bearer ' . Auth::user()->github_token,
            'X-GitHub-Api-Version' => '2022-11-28',
            'Content-Type' => 'application/json',
        ];
    }

    /**
     * Gets.
     *
     * @param string $path the path of the gist
     * 
     * @return mixed the response content
     */
    public function get($path)
    {
        $url = $this->baseUrl . $path;

        $response = $this->client->request('GET', $url, [
            'headers' => $this->headers,
            'http_errors' => false
        ]);

        $body = $response->getBody();
        $data = json_decode($body, true);

        return $data;
    }

    /**
     * Posts.
     *
     * @param array $data the data to post
     * 
     * @return mixed the response content
     */
    public function post($data, $path)
    {
        $url = $this->baseUrl . $path;

        $response = $this->client->request('POST', $url, [
            'headers' => $this->headers,
            'json' => $data
        ]);
        
        $body = $response->getBody();
        $data = json_decode($body, true);

        return $data;
    }

    /**
     * Patch.
     *
     * @param string $gistId the ID of the gist
     * @param array $data the data to patch
     * 
     * @return mixed the response content
     */
    public function patch($data, $path)
    {
        $url = $this->baseUrl . $path;

        $response = $this->client->request('PATCH', $url, [
            'headers' => $this->headers,
            'http_errors' => false,
            'json' => $data
        ]);

        $body = $response->getBody();
        $data = json_decode($body, true);

        return $data;
    }

    /**
     * Puts.
     *
     * @param string $path The path to send the request to.
     * @return mixed The response data.
     */
    public function put($path)
    {
        $url = $this->baseUrl . $path;

        $response = $this->client->request('PUT', $url, [
            'headers' => $this->headers,
            'http_errors' => false,
        ]);

        $body = $response->getBody();
        $data = json_decode($body, true);

        return $data;
    }

    /**
     * Deletes.
     *
     * @param string $gistId the ID of the gist
     * @throws Exception if there is an error with the cURL request
     * 
     * @return mixed the response content
     */
    public function delete($path)
    {
        $url = $this->baseUrl . $path;
        $response = $this->client->request('DELETE', $url, [
            'headers' => $this->headers,
            'http_errors' => false
        ]);

        $body = $response->getBody();
        $data = json_decode($body, true);

        return $data;
    }
}