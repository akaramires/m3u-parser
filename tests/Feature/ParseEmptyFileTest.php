<?php

declare(strict_types=1);

namespace Akaramires\M3uParser\Tests\Feature;

use Akaramires\M3uParser\Exceptions\PlaylistIsEmptyException;
use Akaramires\M3uParser\Exceptions\PlaylistNotFoundException;
use Akaramires\M3uParser\Services\M3uParser;
use Akaramires\M3uParser\Sources\FileSource;
use PHPUnit\Framework\TestCase;

class ParseEmptyFileTest extends TestCase
{
    /**
     * @throws PlaylistNotFoundException
     */
    public function testParser(): void
    {
        $source = new FileSource(__DIR__ . '/../Data/emptyfile.m3u');
        $parser = new M3uParser();

        $this->expectException(PlaylistIsEmptyException::class);

        $parser->load($source);
    }
}
