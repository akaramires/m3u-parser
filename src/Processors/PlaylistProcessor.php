<?php

declare(strict_types=1);

namespace Akaramires\M3uParser\Processors;

use Akaramires\M3uParser\Contracts\ProcessorContract;
use Akaramires\M3uParser\Contracts\SourceContract;
use Akaramires\M3uParser\Dto\ChannelDto;
use Akaramires\M3uParser\Dto\PlaylistDto;
use Akaramires\M3uParser\Tags\BaseTag;
use Akaramires\M3uParser\Tags\ChannelAttributeTag;
use Akaramires\M3uParser\Tags\ExtInfTag;
use Akaramires\M3uParser\Tags\ExtM3UTag;
use Akaramires\M3uParser\Tags\PlaylistAttributeTag;
use Akaramires\M3uParser\Tags\PlaylistAttributeWithoutValueTag;
use Akaramires\M3uParser\Tags\UrlTag;
use Akaramires\M3uParser\Traits\AttributesTrait;

class PlaylistProcessor implements ProcessorContract
{
    use AttributesTrait;

    private PlaylistDto $playlist;

    private string $content;

    public function __construct()
    {
        $this->playlist = new PlaylistDto();
    }

    public function load(SourceContract $source): self
    {
        $source->validate();

        $this->content = $source->getContent();

        return $this;
    }

    public function parse(): self
    {
        $lines = explode(PHP_EOL, $this->content);
        $lines = array_filter($lines);

        $this->parsePlaylistLines($lines);
        $this->parseChannelsLines($lines);

        return $this;
    }

    public function parsePlaylistLines(array $lines): void
    {
        $lines = array_filter($lines);

        foreach ($lines as $line) {
            $tag = BaseTag::detectTag($line);

            if ($tag instanceof ExtM3UTag) {
                $this->playlist->inlineAttributes = $tag->getInlineAttributes($line);
            } elseif ($tag instanceof PlaylistAttributeTag) {
                $this->playlist->addAttribute($tag->getAttribute($line));
            } elseif ($tag instanceof PlaylistAttributeWithoutValueTag) {
                $this->playlist->addAttributeWithoutValue($tag->getAttributeWithoutValue());
            }
        }
    }

    public function parseChannelsLines(array $lines): void
    {
        $blocks = $this->getChannelsSeparatedBlocks($lines);

        foreach ($blocks as $block) {
            $lines = explode(PHP_EOL, $block);
            $lines = array_filter($lines);

            $channel = new ChannelDto();

            foreach ($lines as $line) {
                $tag = BaseTag::detectTag($line);

                if ($tag instanceof ExtInfTag) {
                    $channel->title = $tag->getTitle($line);
                    $channel->duration = $tag->getDuration($line);
                    $channel->inlineAttributes = $tag->getInlineAttributes($line);
                }

                if ($tag instanceof ChannelAttributeTag) {
                    $channel->addAttribute($tag->getAttribute($line));
                }

                if ($tag instanceof UrlTag) {
                    $channel->url = $tag->line;
                }
            }

            $this->playlist->addChannel($channel);
        }
    }

    // TODO: отрефакторить. не нравится
    private function getChannelsSeparatedBlocks(array $lines): array
    {
        $content = '';

        $lines = array_filter($lines);

        foreach ($lines as $line) {
            $tag = BaseTag::detectTag($line);

            if (
                !($tag instanceof ExtInfTag) &&
                !($tag instanceof ChannelAttributeTag) &&
                !($tag instanceof UrlTag)
            ) {
                continue;
            }

            $content .= trim($line) . PHP_EOL;
        }

        $content = $this->removeLineBreakAtTheEnd($content);

        preg_match_all('/^[^#]+$/mi', $content, $urls, PREG_SET_ORDER, 0);

        $channelsAttributes = preg_split('/^[^#]+$/mi', $content);

        $channelsAttributes = array_map(
            fn(string $channelAttributes, int $index) => rescue(
                callback: fn() => $this->removeLineBreakAtTheEnd($channelAttributes) . PHP_EOL . $urls[$index][0],
                rescue: '',
                report: false,
            ),
            $channelsAttributes,
            array_keys($channelsAttributes)
        );

        $channelsAttributes = array_filter($channelsAttributes);

        return array_map(
            fn(string $block) => $this->removeLineBreakAtStart($block),
            $channelsAttributes
        );
    }

    public function getPlaylist(): PlaylistDto
    {
        return $this->playlist;
    }

    private function removeLineBreakAtStart(string $text): string
    {
        return preg_replace("/^\n/", '', $text);
    }

    private function removeLineBreakAtTheEnd(string $text): string
    {
        return preg_replace("/\n$/", '', $text);
    }
}
