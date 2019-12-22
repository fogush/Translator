<?php

namespace App\Translator;

use App\Entity\Translator;

interface StorageInterface
{
    public function save(Translator $translator): bool;
    public function get(): Translator;
}
