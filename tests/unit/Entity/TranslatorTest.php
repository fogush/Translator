<?php

namespace App\Tests\Entity;

use App\Entity\Translator;
use Codeception\Test\Unit;

class TranslatorTest extends Unit
{
    public function testGetNothingOnEmptyTranslator()
    {
        $translator = new Translator();

        $this->assertNull($translator->getContent());
    }

    public function testSetContent()
    {
        $translator = new Translator();
        $translator->setContent('Something');

        $this->assertEquals('Something', $translator->getContent());
    }
}
