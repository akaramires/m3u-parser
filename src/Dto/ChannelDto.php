<?php

declare(strict_types=1);

namespace Akaramires\M3uParser\Dto;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class ChannelDto extends Data
{
    public DataCollection $attributes;

    public function __construct()
    {
        $this->attributes = new DataCollection(AttributeDto::class, []);
    }
}
