<?php

declare(strict_types=1);

namespace Akaramires\M3uParser\Tests\Feature;

use Akaramires\M3uParser\Exceptions\PlaylistIsEmptyException;
use Akaramires\M3uParser\Exceptions\PlaylistNotFoundException;
use Akaramires\M3uParser\Processors\PlaylistProcessor;
use Akaramires\M3uParser\Sources\FileSource;
use Tests\TestCase;

class ParseMinimalPlaylistTest extends TestCase
{
    /**
     * @throws PlaylistIsEmptyException
     * @throws PlaylistNotFoundException
     */
    public function testParser(): void
    {
        $source = new FileSource(__DIR__ . '/../Data/minimalplaylist.m3u');

        /** @var PlaylistProcessor $processor */
        $processor = app(PlaylistProcessor::class);

        $processor->load($source);
        $processor->parse();

        $playlist = $processor->getPlaylist();

        $this->assertEquals(5, $playlist->inlineAttributes->count());
        $this->assertEquals(0, $playlist->attributes->count());
        $this->assertEquals(0, $playlist->attributesWithoutValue->count());
        $this->assertEquals(2, $playlist->channels->count());
    }
}
