<?php

declare(strict_types=1);

namespace Akaramires\M3uParser\Dto;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class PlaylistDto extends Data
{
    public DataCollection $inlineAttributes;
    public DataCollection $attributes;
    public DataCollection $attributesWithoutValue;
    public DataCollection $channels;
    public DataCollection $comments;

    public function __construct()
    {
        $this->inlineAttributes = new DataCollection(AttributeDto::class, []);
        $this->attributes = new DataCollection(AttributeDto::class, []);
        $this->attributesWithoutValue = new DataCollection(AttributeWithoutValueDto::class, []);
        $this->channels = new DataCollection(ChannelDto::class, []);
        $this->comments = new DataCollection(CommentDto::class, []);
    }

    public function addInlineAttribute(AttributeDto $attribute): void
    {
        $this->inlineAttributes = $this->attributes->merge(
            new DataCollection(AttributeDto::class, [$attribute])
        );
    }

    public function addAttribute(AttributeDto $attribute): void
    {
        $this->attributes = $this->attributes->merge(
            new DataCollection(AttributeDto::class, [$attribute])
        );
    }

    public function addComment(CommentDto $comment): void
    {
        $this->comments = $this->comments->merge(
            new DataCollection(CommentDto::class, [$comment])
        );
    }

    public function addAttributeWithoutValue(AttributeWithoutValueDto $attribute): void
    {
        $this->attributesWithoutValue = $this->attributesWithoutValue->merge(
            new DataCollection(AttributeWithoutValueDto::class, [$attribute])
        );
    }

    public function addChannel(ChannelDto $channel): void
    {
        $this->channels = $this->channels->merge(
            new DataCollection(ChannelDto::class, [$channel])
        );
    }
}
