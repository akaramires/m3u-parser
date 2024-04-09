<?php

declare(strict_types=1);

namespace Akaramires\M3uParser\Tags;

use Akaramires\M3uParser\Contracts\TagContract;

class UrlTag implements TagContract
{
    public function __construct(
        public readonly string $line,
    ) {
    }
}
