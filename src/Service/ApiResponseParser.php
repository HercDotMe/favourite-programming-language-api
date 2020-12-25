<?php

namespace App\Service;

interface ApiResponseParser
{
    public function parseRepositoriesResponse(string $response): array;

    public function parseLanguagesResponse(string $response): array;
}
