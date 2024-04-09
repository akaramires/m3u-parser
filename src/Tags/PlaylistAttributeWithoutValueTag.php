<?php

declare(strict_types=1);

namespace Akaramires\M3uParser\Tags;

use Akaramires\M3uParser\Dto\AttributeWithoutValueDto;

class PlaylistAttributeWithoutValueTag extends BaseTag
{
    public function getAttributeWithoutValue(): AttributeWithoutValueDto
    {
        return new AttributeWithoutValueDto($this->tagName->value);
    }

    protected function hasColonInName(): bool
    {
        return false;
    }
}
