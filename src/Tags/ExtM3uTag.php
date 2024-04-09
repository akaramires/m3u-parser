<?php

declare(strict_types=1);

namespace Akaramires\M3uParser\Tags;

use Akaramires\M3uParser\Traits\AttributesTrait;
use Spatie\LaravelData\DataCollection;

class ExtM3uTag extends BaseTag
{
    use AttributesTrait;

    public function getInlineAttributes(string $line): DataCollection
    {
        $line = $this->removeTagString($line);

        return $this->extractAttributes($line);
    }

    protected function hasColonInName(): bool
    {
        return false;
    }
}
