<?php

namespace App\Tests\Translator;

use App\Entity\Translator;
use App\Translator\FileStorage;
use Codeception\Stub;
use Codeception\Test\Unit;
use Gaufrette\File;
use Gaufrette\Filesystem;
use Knp\Bundle\GaufretteBundle\FilesystemMap;

class FileStorageTest extends Unit
{
    /**
     * @var \App\Tests\UnitTester
     */
    protected $tester;

    private function getFilesystemMapMock($mockProperties): FilesystemMap
    {
        $filesystemMock = $this->make(Filesystem::class, $mockProperties);
        $filesystemMapMock = $this->make(FilesystemMap::class, ['get' => $filesystemMock]);

        return $filesystemMapMock;
    }

    public function testSave()
    {
        $filesystemMapMock = $this->getFilesystemMapMock(['write' => Stub\Expected::once()]);

        $translator = new Translator();
        $translator->setContent('Something');

        $fileStorage = new FileStorage($filesystemMapMock);
        $fileStorage->save($translator);
    }

    public function testGet()
    {
        $fileMock = $this->make(File::class, ['getContent' => 'Something']);
        $filesystemMapMock = $this->getFilesystemMapMock(['get' => $fileMock]);

        $fileStorage = new FileStorage($filesystemMapMock);
        $translator = $fileStorage->get();

        $this->assertInstanceOf(Translator::class, $translator);
        $this->assertSame('Something', $translator->getContent());
    }
}
