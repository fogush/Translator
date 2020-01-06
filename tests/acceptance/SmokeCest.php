<?php

namespace App\Tests;

use App\Tests\AcceptanceTester;

class SmokeCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function openHomepage(AcceptanceTester $I): void
    {
        $I->amOnPage('/');
        $I->see('Save');
    }
}
