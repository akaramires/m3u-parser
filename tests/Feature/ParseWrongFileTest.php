<?php

declare(strict_types=1);

namespace Akaramires\M3uParser\Tests\Feature;

use Akaramires\M3uParser\Exceptions\PlaylistIsEmptyException;
use Akaramires\M3uParser\Exceptions\PlaylistNotFoundException;
use Akaramires\M3uParser\Services\M3uParser;
use Akaramires\M3uParser\Sources\FileSource;
use PHPUnit\Framework\TestCase;

class ParseWrongFileTest extends TestCase
{
    /**
     * @throws PlaylistIsEmptyException
     */
    public function testParser(): void
    {
        $source = new FileSource('wrong.m3u');
        $parser = new M3uParser();

        $this->expectException(PlaylistNotFoundException::class);

        $parser->load($source);
    }
}
