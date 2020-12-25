<?php

namespace App\Service;

use App\Entity\ProgrammingLanguage;
use App\Entity\Repository;
use JsonException;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;

class GitHubApiResponseParser implements ApiResponseParser
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * {@inheritDoc}
     *
     * @throws JsonException
     */
    public function parseRepositoriesResponse(string $response): array
    {
        try {
            $repositories = $this->serializer->deserialize($response, Repository::class.'[]', 'json');
        } catch (NotEncodableValueException $neve) {
            throw new JsonException($neve);
        }

        return $repositories;
    }

    /**
     * {@inheritDoc}
     *
     * @throws JsonException
     */
    public function parseLanguagesResponse(string $response): array
    {
        $response = json_decode($response);
        if (null === $response) {
            throw new JsonException('Could not json decode languages!');
        }

        $languages = [];
        foreach ($response as $key => $value) {
            $languages[] = (new ProgrammingLanguage())->setName($key)->setByteCount($value);
        }

        return $languages;
    }
}
