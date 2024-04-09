<?php

declare(strict_types=1);

namespace Akaramires\M3uParser\Tags;

use Akaramires\M3uParser\Traits\AttributesTrait;
use Spatie\LaravelData\DataCollection;

class ExtInfTag extends BaseTag
{
    use AttributesTrait;

    protected function hasColonInName(): bool
    {
        return true;
    }

    public function getDuration(string $line)
    {
        $line = $this->removeTagString($line);

        preg_match('/^(-?[\d\.]+)\s*(?:(?:[^=]+=["][^"]*["])|(?:[^=]+=[^ ]*))*,(.*)$/', $line, $matches);

        return $matches[1];
    }

    public function getTitle(string $line)
    {
        $line = $this->removeTagString($line);

        preg_match('/^(-?[\d\.]+)\s*(?:(?:[^=]+=["][^"]*["])|(?:[^=]+=[^ ]*))*,(.*)$/', $line, $matches);

        return $matches[2];
    }

    public function getInlineAttributes(string $line): DataCollection
    {
        $line = $this->removeTagString($line);

        $attributes = preg_replace(
            pattern: '/^' . preg_quote($this->getDuration($line), '/') . '(.*)' . preg_quote($this->getTitle($line), '/') . '$/',
            replacement: '$1',
            subject: $line
        );

        return $this->extractAttributes($attributes);
    }
}
