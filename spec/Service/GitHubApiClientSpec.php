<?php

namespace spec\App\Service;

use App\Entity\ProgrammingLanguage;
use App\Entity\Repository;
use App\Service\ApiResponseParser;
use App\Service\GitHubApiClient;
use PhpSpec\ObjectBehavior;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class GitHubApiClientSpec extends ObjectBehavior
{
    function let(HttpClientInterface $httpClient, ApiResponseParser $parser)
    {
        $this->beConstructedWith('https://test.api.domain', $httpClient, $parser);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(GitHubApiClient::class);
    }

    function it_calls_user_repo_list_endpoint(HttpClientInterface $httpClient, ApiResponseParser $parser, ResponseInterface $response)
    {
        $endpoint = 'https://test.api.domain/users/test_user/repos';
        $responseJSON = file_get_contents(__DIR__ . '/../data/repositories.json');
        $expectedResult = [
            (new Repository())
                ->setId(1296269)
                ->setName("Hello-World")
                ->setFullName("octocat/Hello-World")
                ->setUrl("https://api.github.com/repos/octocat/Hello-World")
        ];

        $httpClient->request('GET', $endpoint)->shouldBeCalled()->willReturn($response);
        $response->getContent()->shouldBeCalled()->willReturn($responseJSON);
        $parser->parseRepositoriesResponse($responseJSON)->shouldBeCalled()->willReturn($expectedResult);

        $this->getUserRepositories('test_user')->shouldBeLike($expectedResult);
    }

    function it_calls_repo_languages_list_endpoint(HttpClientInterface $httpClient, ApiResponseParser $parser, ResponseInterface $response)
    {
        $endpoint = 'https://test.api.domain/repos/test/repo/languages';
        $responseJSON = file_get_contents(__DIR__ . '/../data/languages.json');
        $expectedResult = [
            (new ProgrammingLanguage())->setName('C')->setByteCount(78769),
            (new ProgrammingLanguage())->setName('Python')->setByteCount(7769)
        ];

        $httpClient->request('GET', $endpoint)->shouldBeCalled()->willReturn($response);
        $response->getContent()->shouldBeCalled()->willReturn($responseJSON);
        $parser->parseLanguagesResponse($responseJSON)->shouldBeCalled()->willReturn($expectedResult);

        $this->getRepositoryLanguages('test/repo')->shouldBeLike($expectedResult);
    }
}
