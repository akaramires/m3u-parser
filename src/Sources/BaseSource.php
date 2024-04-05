<?php

declare(strict_types=1);

namespace Akaramires\M3uParser\Sources;

use Akaramires\M3uParser\Contracts\SourceContract;

abstract class BaseSource implements SourceContract
{
    public function __construct(
        public readonly string $source,
    ) {
    }
}
