<?php

declare(strict_types=1);

namespace Akaramires\M3uParser\Tests\Feature;

use Akaramires\M3uParser\Exceptions\PlaylistIsEmptyException;
use Akaramires\M3uParser\Exceptions\PlaylistNotFoundException;
use Akaramires\M3uParser\Processors\PlaylistProcessor;
use Akaramires\M3uParser\Sources\FileSource;
use Tests\TestCase;

class ParsePlaylistTest extends TestCase
{
    /**
     * @throws PlaylistIsEmptyException
     * @throws PlaylistNotFoundException
     */
    public function testParser(): void
    {
        $source = new FileSource(__DIR__ . '/../Data/playlist.m3u');

        /** @var PlaylistProcessor $processor */
        $processor = app(PlaylistProcessor::class);

        $processor->load($source);
        $processor->parse();

        $playlist = $processor->getPlaylist();

        $this->assertEquals(5, $playlist->inlineAttributes->count());
        $this->assertEquals(9, $playlist->attributes->count());
        $this->assertEquals(1, $playlist->attributesWithoutValue->count());
        $this->assertEquals(4, $playlist->channels->count());

        $this->assertEquals(3, $playlist->channels[0]->inlineAttributes->count());
        $this->assertEquals(5, $playlist->channels[0]->attributes->count());

        $this->assertEquals(0, $playlist->channels[1]->inlineAttributes->count());
        $this->assertEquals(5, $playlist->channels[1]->attributes->count());

        $this->assertEquals(3, $playlist->channels[2]->inlineAttributes->count());
        $this->assertEquals(0, $playlist->channels[2]->attributes->count());

        $this->assertEquals(0, $playlist->channels[3]->inlineAttributes->count());
        $this->assertEquals(0, $playlist->channels[3]->attributes->count());
    }
}
