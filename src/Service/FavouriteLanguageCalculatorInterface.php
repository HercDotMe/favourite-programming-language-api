<?php

namespace App\Service;

use App\Entity\ProgrammingLanguage;

interface FavouriteLanguageCalculatorInterface
{
    /**
     * @param ProgrammingLanguage[] $languages
     * @return ProgrammingLanguage
     */
    public function getFavouriteLanguage(array $languages): ProgrammingLanguage;
}
