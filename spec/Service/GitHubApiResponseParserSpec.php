<?php

namespace spec\App\Service;

use App\Entity\ProgrammingLanguage;
use App\Entity\Repository;
use App\Service\GitHubApiResponseParser;
use JsonException;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class GitHubApiResponseParserSpec extends ObjectBehavior
{
    function let()
    {
        $serializer = new Serializer([
            new ObjectNormalizer(),
            new ArrayDenormalizer()
        ], [
            new JsonEncoder()
        ]);

        $this->beConstructedWith($serializer);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(GitHubApiResponseParser::class);
    }

    function it_validates_response_as_json()
    {
        $this->shouldThrow(JsonException::class)->during('parseRepositoriesResponse', ['this is not json']);
    }

    function it_deserializes_repositories_json()
    {
        $expectedResult = [
            (new Repository())
                ->setId(1296269)
                ->setName("Hello-World")
                ->setFullName("octocat/Hello-World")
                ->setUrl("https://api.github.com/repos/octocat/Hello-World")
        ];

        $responseJSON = file_get_contents(__DIR__ . '/../data/repositories.json');
        $this->parseRepositoriesResponse($responseJSON)->shouldBeLike($expectedResult);
    }

    function it_deserializes_languages_json()
    {
        $expectedResult = [
            (new ProgrammingLanguage())->setName('C')->setByteCount(78769),
            (new ProgrammingLanguage())->setName('Python')->setByteCount(7769)
        ];

        $responseJSON = file_get_contents(__DIR__ . '/../data/languages.json');
        $this->parseLanguagesResponse($responseJSON)->shouldBeLike($expectedResult);
    }
}
