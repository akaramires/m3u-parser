<?php

declare(strict_types=1);

namespace Akaramires\M3uParser\Dto;

use Spatie\LaravelData\Data;

class AttributeDto extends Data
{
    public function __construct(
        public string $key,
        public string $value,
    ) {
    }
}
