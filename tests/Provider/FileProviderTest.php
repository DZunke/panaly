<?php

declare(strict_types=1);

namespace Panaly\Test\Provider;

use Panaly\Provider\FileProvider;
use PHPUnit\Framework\TestCase;

use function file_put_contents;
use function sprintf;
use function unlink;

class FileProviderTest extends TestCase
{
    public function testThatReadingADirectoryIsNotPossible(): void
    {
        $this->expectException(FileProvider\InvalidFileAccess::class);
        $this->expectExceptionMessage(sprintf('The provided file path "%s" is a directory.', __DIR__));

        (new FileProvider())->read(__DIR__);
    }

    public function testThatReadingAFileWillDeliverContent(): void
    {
        $content = (new FileProvider())->read(__FILE__);

        self::assertStringEqualsFile(
            __FILE__,
            $content,
            'The provider did not return the content of "' . __FILE__ . '"',
        );
    }

    public function testThatRemovingAFileThatWasNotReadIsNotPossible(): void
    {
        $this->expectException(FileProvider\InvalidFileAccess::class);
        $this->expectExceptionMessage(
            'The provided file "foo.txt" was not read by the provider and can so not be removed',
        );

        (new FileProvider())->remove('foo.txt');
    }

    public function testReadWriteRemoveWorkflowIsFullyWorking(): void
    {
        file_put_contents('foo.txt', 'foo'); // Create temporary file

        self::assertSame('foo', (new FileProvider())->read('foo.txt'));
        (new FileProvider())->write('foo.txt', 'bar');
        self::assertSame('bar', (new FileProvider())->read('foo.txt'));

        // Manually remove the file - reader should work?
        @unlink('foo.txt');
        self::assertSame('bar', (new FileProvider())->read('foo.txt'));

        (new FileProvider())->remove('foo.txt');

        self::assertFileDoesNotExist('foo.txt');
    }
}
