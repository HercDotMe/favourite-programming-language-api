<?php

namespace App\Service;

use App\Entity\Repository;
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
    public function getUserRepositories(string $identifier): array
    {
        $endpoint = sprintf($this->apiDomain.'/users/%s/repos', $identifier);
        $response = $this->client->request('GET', $endpoint)->getContent();

        return $this->responseParser->parseRepositoriesResponse($response);
    }

    /**
     * {@inheritDoc}
     */
    public function getRepositoryLanguages(Repository $repository): array
    {
        $endpoint = sprintf($this->apiDomain.'/repos/%s/languages', $repository->getFullName());
        $response = $this->client->request('GET', $endpoint)->getContent();

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
