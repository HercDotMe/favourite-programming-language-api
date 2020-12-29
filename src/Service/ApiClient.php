<?php

namespace App\Service;

use App\Entity\ProgrammingLanguage;
use App\Entity\Repository;

interface ApiClient
{
    /**
     * @param string $identifier
     * @return Repository[]
     */
    public function getUserRepositories(string $identifier): array;

    /**
     * @param Repository $repository
     * @return ProgrammingLanguage[]
     */
    public function getRepositoryLanguages(Repository $repository): array;

    /**
     * @param string $identifier
     * @return ProgrammingLanguage[]
     */
    public function getUserLanguages(string $identifier): array;
}
