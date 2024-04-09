<?php

declare(strict_types=1);

namespace Akaramires\M3uParser\Tags;

use Akaramires\M3uParser\Dto\AttributeDto;

class PlaylistAttributeTag extends BaseTag
{
    public function getAttribute(string $line): AttributeDto
    {
        $line = $this->removeTagString($line);
        $value = trim($line);

        return new AttributeDto($this->tagName->value, $value);
    }

    protected function hasColonInName(): bool
    {
        return true;
    }
}
