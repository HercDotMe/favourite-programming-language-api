<?php

namespace App\Service;

use App\Entity\Repository;

interface ApiClient
{
    /**
     * @return Repository[]
     */
    public function getUserRepositories(string $username): array;

    /**
     * @return Repository[]
     */
    public function getRepositoryLanguages(string $repositoryName): array;
}
