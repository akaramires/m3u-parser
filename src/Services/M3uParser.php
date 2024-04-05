<?php

declare(strict_types=1);

namespace Akaramires\M3uParser\Services;

use Akaramires\M3uParser\Dto\AttributeDto;
use Akaramires\M3uParser\Dto\PlaylistDto;
use Akaramires\M3uParser\Exceptions\PlaylistIsEmptyException;
use Akaramires\M3uParser\Exceptions\PlaylistNotFoundException;
use Akaramires\M3uParser\Sources\BaseSource;
use Spatie\LaravelData\DataCollection;

class M3uParser
{
    private PlaylistDto $playlist;

    private string $content;

    public function __construct()
    {
        $this->playlist = new PlaylistDto();
    }

    public function getPlaylist(): PlaylistDto
    {
        return $this->playlist;
    }

    /**
     * @throws PlaylistIsEmptyException
     * @throws PlaylistNotFoundException
     */
    public function load(BaseSource $source): self
    {
        $source->validate();

        $this->content = $source->getContent();

        $this->removeBom();

        return $this;
    }

    public function removeBom(): void
    {
        if (str_starts_with($this->content, "\xEF\xBB\xBF")) {
            $this->content = substr($this->content, 3);
        }
    }

    public function addTag(): self
    {
        return $this;
    }

    public function isM3u(string $line): bool
    {
        return str_starts_with($line, '#EXTM3U');
    }

    public function parse(): self
    {
        $lines = explode(PHP_EOL, $this->content);

        $lines = array_map(fn(string $line) => trim(preg_replace('~[\r\n]+~', '', $line)), $lines);
        $lines = array_filter($lines);

        foreach ($lines as $line) {
            if ($this->isM3u($line)) {
                $tmp = trim(substr($line, 7));

                $this->playlist->attributes = $this->parseAttributes($tmp);

                continue;
            }
        }

        return $this;
    }

    private function parseAttributes(string $attrString): DataCollection
    {
        $attributes = [];

        preg_match_all('/([a-zA-Z0-9\-]+)="([^"]*)"/', $attrString, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $attributes[] = new AttributeDto(key: $match[1], value: $match[2]);
        }

        preg_match_all('/([a-zA-Z0-9\-]+)=([^ "]+)/', $attrString, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $attributes[] = new AttributeDto(key: $match[1], value: $match[2]);
        }

        return new DataCollection(AttributeDto::class, $attributes);
    }
}
