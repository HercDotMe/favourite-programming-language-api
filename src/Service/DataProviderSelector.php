<?php

namespace App\Service;

use InvalidArgumentException;

class DataProviderSelector
{
    const GITHUB_PROVIDER = 'github';

    private array $providers;

    public function __construct(
        GitHubApiClient $githubClient
    ) {
        $this->providers[self::GITHUB_PROVIDER] = $githubClient;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function selectProvider(string $identifier): ApiClient
    {
        switch (strtolower($identifier)) {
            case self::GITHUB_PROVIDER:
                return $this->providers[self::GITHUB_PROVIDER];

            default:
                throw new InvalidArgumentException("Provider '$identifier' not supported!");
        }
    }
}
