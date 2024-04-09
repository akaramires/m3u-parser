<?php

declare(strict_types=1);

namespace Akaramires\M3uParser\Dto;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class ChannelDto extends Data
{
    public null|string $title = null;
    public null|string $duration = null;
    public null|string $url = null;

    public DataCollection $inlineAttributes;
    public DataCollection $attributes;

    public function __construct()
    {
        $this->inlineAttributes = new DataCollection(AttributeDto::class, []);
        $this->attributes = new DataCollection(AttributeDto::class, []);
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
}
