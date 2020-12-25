<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class GitHubApiClient implements ApiClient
{
    private string $apiDomain;

    private HttpClientInterface $client;
    private ApiResponseParser $responseParser;

    public function __construct(string $apiDomain, HttpClientInterface $client, ApiResponseParser $responseParser)
    {
        $this->apiDomain = $apiDomain;
        $this->client = $client;
        $this->responseParser = $responseParser;
    }

    /**
     * {@inheritDoc}
     */
    public function getUserRepositories(string $username): array
    {
        $endpoint = sprintf($this->apiDomain.'/users/%s/repos', $username);
        $response = $this->client->request('GET', $endpoint)->getContent();

        return $this->responseParser->parseRepositoriesResponse($response);
    }

    /**
     * {@inheritDoc}
     */
    public function getRepositoryLanguages(string $repositoryName): array
    {
        $endpoint = sprintf($this->apiDomain.'/repos/%s/languages', $repositoryName);
        $response = $this->client->request('GET', $endpoint)->getContent();

        return $this->responseParser->parseLanguagesResponse($response);
    }
}
