<?php

declare(strict_types=1);

namespace Akaramires\M3uParser\Dto;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class PlaylistDto extends Data
{
    public DataCollection $attributes;
    public DataCollection $channels;

    public function __construct()
    {
        $this->attributes = new DataCollection(AttributeDto::class, []);
        $this->channels = new DataCollection(ChannelDto::class, []);
    }
}
