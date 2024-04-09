<?php

declare(strict_types=1);

namespace Akaramires\M3uParser\Tags;

use Akaramires\M3uParser\Contracts\TagContract;
use Akaramires\M3uParser\Dto\CommentDto;

class CommentTag implements TagContract
{
    public function __construct(
        private readonly string $line,
    ) {
    }

    public function getDto(): CommentDto
    {
        return new CommentDto($this->line);
    }
}
