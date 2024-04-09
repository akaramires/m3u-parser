<?php

declare(strict_types=1);

namespace Akaramires\M3uParser\Dto;

use Spatie\LaravelData\Data;

class AttributeWithoutValueDto extends Data
{
    public function __construct(
        public string $key,
    ) {
    }
}
