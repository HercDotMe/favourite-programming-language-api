<?php

namespace spec\App\Controller\Api;

use App\Controller\Api\FavouriteLanguageController;
use App\Entity\ProgrammingLanguage;
use App\Service\ApiClient;
use App\Service\DataProviderSelector;
use App\Service\FavouriteLanguageCalculatorInterface;
use PhpSpec\ObjectBehavior;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class FavouriteLanguageControllerSpec extends ObjectBehavior
{
    function let(
        DataProviderSelector $dataProviderSelector,
        FavouriteLanguageCalculatorInterface $favouriteLanguageCalculator,
        LoggerInterface $logger
    )
    {
        $serializer = new Serializer([
            new ObjectNormalizer(),
            new ArrayDenormalizer()
        ], [
            new JsonEncoder()
        ]);

        $this->beConstructedWith($dataProviderSelector, $favouriteLanguageCalculator, $serializer, $logger);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FavouriteLanguageController::class);
    }

    function it_returns_users_favourite_language(
        DataProviderSelector $dataProviderSelector,
        FavouriteLanguageCalculatorInterface $favouriteLanguageCalculator,
        ApiClient $apiClient
    )
    {
        $serializer = new Serializer([
            new ObjectNormalizer(),
            new ArrayDenormalizer()
        ], [
            new JsonEncoder()
        ]);

        $language = (new ProgrammingLanguage())->setName('test_language')->setByteCount(1111);

        $dataProviderSelector->selectProvider('test_provider')->shouldBeCalled()->willReturn($apiClient);
        $apiClient->getUserLanguages('test_user')->shouldBeCalled()->willReturn([$language]);
        $favouriteLanguageCalculator->getFavouriteLanguage([$language])->shouldBeCalled()->willReturn($language);

        $response = new Response($serializer->serialize($language, 'json'));

        $this->getFavouriteLanguage('test_provider', 'test_user')->shouldBeLike($response);
    }
}
