<?php

namespace App\Service;

use App\Entity\Repository;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GitHubApiClient implements ApiClient
{
    private string $apiDomain;

    private HttpClientInterface $client;
    private ApiResponseParser $responseParser;
    private string $authToken;

    public function __construct(string $apiDomain, HttpClientInterface $client, ApiResponseParser $responseParser, string $authToken)
    {
        $this->apiDomain = $apiDomain;
        $this->client = $client;
        $this->responseParser = $responseParser;
        $this->authToken = $authToken;
    }

    /**
     * {@inheritDoc}
     */
    public function getUserRepositories(string $identifier): array
    {
        $endpoint = sprintf($this->apiDomain.'/users/%s/repos', $identifier);
        $response = $this->client->request('GET', $endpoint, [
            'auth_bearer' => $this->authToken
        ])->getContent();

        return $this->responseParser->parseRepositoriesResponse($response);
    }

    /**
     * {@inheritDoc}
     */
    public function getRepositoryLanguages(Repository $repository): array
    {
        $endpoint = sprintf($this->apiDomain.'/repos/%s/languages', $repository->getFullName());
        $response = $this->client->request('GET', $endpoint, [
            'auth_bearer' => $this->authToken
        ])->getContent();

        return $this->responseParser->parseLanguagesResponse($response);
    }

    /**
     * {@inheritDoc}
     */
    public function getUserLanguages(string $identifier): array
    {
        $repositories = $this->getUserRepositories($identifier);

        $languages = [];
        foreach ($repositories as $repository) {
            $languages = array_merge($this->getRepositoryLanguages($repository), $languages);
        }

        return $languages;
    }
}
