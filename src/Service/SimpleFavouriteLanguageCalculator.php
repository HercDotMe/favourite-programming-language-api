<?php

namespace App\Service;

use App\Entity\ProgrammingLanguage;

class SimpleFavouriteLanguageCalculator implements FavouriteLanguageCalculatorInterface
{
    /**
     * {@inheritDoc}
     */
    public function getFavouriteLanguage(array $languages): ProgrammingLanguage
    {
        $foundLanguages = [];

        foreach ($languages as $language) {
            if (!isset($foundLanguages[$language->getName()])) {
                $foundLanguages[$language->getName()] = $language->getByteCount();
            } else {
                $foundLanguages[$language->getName()] += $language->getByteCount();
            }
        }

        arsort($foundLanguages);
        reset($foundLanguages);

        return (new ProgrammingLanguage())->setName(array_key_first($foundLanguages))->setByteCount(current($foundLanguages));
    }
}
