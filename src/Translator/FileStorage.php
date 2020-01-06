<?php

namespace App\Translator;

use App\Entity\Translator;
use Knp\Bundle\GaufretteBundle\FilesystemMap;

class FileStorage implements StorageInterface
{
    private const STORAGE_FILE = 'translator_storage.txt';

    private $filesystem;

    public function __construct(FilesystemMap $filesystem)
    {
        $this->filesystem = $filesystem->get('translator');
    }

    public function save(Translator $translator): bool
    {
        $this->filesystem->write(static::STORAGE_FILE, $translator->getContent(), true);

        return true;
    }

    public function get(): Translator
    {
        $content = $this->filesystem->get(static::STORAGE_FILE, true);

        $translator = new Translator();
        $translator->setContent($content->getContent());

        return $translator;
    }
}
