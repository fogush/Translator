<?php

namespace App\Form\Handler;

use App\Translator\StorageInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class TranslatorHandler
{
    private $dataStorage;

    public function __construct(StorageInterface $dataStorage)
    {
        $this->dataStorage = $dataStorage;
    }

    public function handle(FormInterface $translatorType, Request $request): bool
    {
        $translatorType->handleRequest($request);

        if ($translatorType->isSubmitted() && $translatorType->isValid()) {
            $this->dataStorage->save($translatorType->getData());

            return true;
        }

        return false;
    }
}
