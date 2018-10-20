<?php

namespace App\Form\Handler;

use App\Translator\DataStorage;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class TranslatorHandler
{
    private $dataStorage;

    public function __construct(DataStorage $dataStorage)
    {
        $this->dataStorage = $dataStorage;
    }

    /**
     * @param FormInterface $translatorType
     * @param Request $request
     * @return bool
     * @throws \App\Exception\StorageException
     */
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
