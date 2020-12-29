<?php

namespace App\Service;

use App\Entity\ProgrammingLanguage;
use App\Entity\Repository;

interface ApiResponseParser
{
    /**
     * @param string $response
     * @return Repository[]
     */
    public function parseRepositoriesResponse(string $response): array;

    /**
     * @param string $response
     * @return ProgrammingLanguage[]
     */
    public function parseLanguagesResponse(string $response): array;
}
