<?php

namespace App\Translator;

use App\Entity\Translator;
use App\Exception\StorageException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class FileStorage implements StorageInterface
{
    private const STORAGE_FILE = 'translator_storage.txt';

    private $storagePath;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $projectDir = $parameterBag->get('kernel.project_dir');
        $this->storagePath = $projectDir . DIRECTORY_SEPARATOR . 'var' . DIRECTORY_SEPARATOR . self::STORAGE_FILE;
    }

    /**
     * @param Translator $translator
     * @return bool
     * @throws StorageException
     */
    public function save(Translator $translator): bool
    {
        $result = file_put_contents($this->storagePath, $translator->getContent());
        if (false === $result) {
            throw new StorageException('Unable to save data');
        }

        return true;
    }

    /**
     * @return Translator
     * @throws StorageException
     */
    public function get(): Translator
    {
        $this->createIfNotExist();

        $content = file_get_contents($this->storagePath);
        if (false === $content) {
            throw new StorageException('Unable to read storage');
        }

        $translator = new Translator();
        $translator->setContent($content);

        return $translator;
    }

    /**
     * @throws StorageException
     */
    private function createIfNotExist(): void
    {
        if (!file_exists($this->storagePath)) {
            if (!touch($this->storagePath)) {
                throw new StorageException('Unable to create storage');
            }
        }
    }
}