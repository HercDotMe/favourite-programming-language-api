<?php

namespace spec\App\Service;

use App\Entity\ProgrammingLanguage;
use App\Service\SimpleFavouriteLanguageCalculator;
use PhpSpec\ObjectBehavior;

class SimpleFavouriteLanguageCalculatorSpec extends ObjectBehavior
{

    function it_is_initializable()
    {
        $this->shouldHaveType(SimpleFavouriteLanguageCalculator::class);
    }

    function it_gets_highest_score_language()
    {
        $this->getFavouriteLanguage(
            [
                (new ProgrammingLanguage())->setName('Python')->setByteCount(1200),
                (new ProgrammingLanguage())->setName('C')->setByteCount(78769)
            ]
        )->shouldBeLike(
            (new ProgrammingLanguage())->setName('C')->setByteCount(78769)
        );
    }
}
