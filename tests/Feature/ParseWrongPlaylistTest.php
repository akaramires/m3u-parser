<?php

declare(strict_types=1);

namespace Akaramires\M3uParser\Tests\Feature;

use Akaramires\M3uParser\Exceptions\PlaylistIsEmptyException;
use Akaramires\M3uParser\Exceptions\PlaylistNotFoundException;
use Akaramires\M3uParser\Processors\PlaylistProcessor;
use Akaramires\M3uParser\Sources\FileSource;
use Tests\TestCase;

class ParseWrongPlaylistTest extends TestCase
{
    /**
     * @throws PlaylistIsEmptyException
     * @throws PlaylistNotFoundException
     */
    public function testParser(): void
    {
        $source = new FileSource(__DIR__ . '/../Data/wrongplaylist.m3u');

        /** @var PlaylistProcessor $processor */
        $processor = app(PlaylistProcessor::class);

        $this->expectException(PlaylistNotFoundException::class);

        $processor->load($source);
        $processor->parse();
    }
}
