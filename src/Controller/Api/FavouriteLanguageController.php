<?php

namespace App\Controller\Api;

use App\Service\DataProviderSelector;
use App\Service\FavouriteLanguageCalculatorInterface;
use InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;

class FavouriteLanguageController
{
    private DataProviderSelector $dataProviderSelector;

    private FavouriteLanguageCalculatorInterface $favouriteLanguageCalculator;

    private Serializer $serializer;

    private LoggerInterface $logger;

    public function __construct(
        DataProviderSelector $dataProviderSelector,
        FavouriteLanguageCalculatorInterface $favouriteLanguageCalculator,
        Serializer $serializer,
        LoggerInterface $logger
    ) {
        $this->dataProviderSelector = $dataProviderSelector;
        $this->favouriteLanguageCalculator = $favouriteLanguageCalculator;
        $this->serializer = $serializer;
        $this->logger = $logger;
    }

    #[Route('/api/favourite-programming-language/{provider}/{username}', name: 'favourite_language')]
    public function getFavouriteLanguage(string $provider, string $username): Response
    {
        $favouriteLanguage = null;

        try {
            $apiClient = $this->dataProviderSelector->selectProvider($provider);
            $favouriteLanguage = $this->favouriteLanguageCalculator->getFavouriteLanguage(
                $apiClient->getUserLanguages($username)
            );
        } catch (InvalidArgumentException $iae) {
            $this->logger->error($iae);

            return new Response($this->serializer->serialize(['error' => $iae->getMessage()], 'json'));
        } catch (ClientException $ce) {
            $this->logger->error($ce);
            if (Response::HTTP_NOT_FOUND == $ce->getCode()) {
                return new Response($this->serializer->serialize(['error' => "User '$username' not found!"], 'json'));
            }
            if (Response::HTTP_INTERNAL_SERVER_ERROR == $ce->getCode()) {
                return new Response($this->serializer->serialize(['error' => 'API error, try again later!'], 'json'));
            }
            if (Response::HTTP_FORBIDDEN == $ce->getCode()) {
                return new Response($this->serializer->serialize(['error' => 'API error: '.$ce->getMessage().'!'], 'json'));
            }
        }

        return new Response($this->serializer->serialize($favouriteLanguage, 'json'));
    }
}
