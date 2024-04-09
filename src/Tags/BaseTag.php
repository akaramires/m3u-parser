<?php

declare(strict_types=1);

namespace Akaramires\M3uParser\Tags;

use Akaramires\M3uParser\Contracts\TagContract;
use Akaramires\M3uParser\Enum\TagNameEnum;

abstract class BaseTag implements TagContract
{
    public function __construct(
        public readonly TagNameEnum $tagName
    ) {
    }

    abstract protected function hasColonInName(): bool;

    public static function detectTag(string $line): TagContract
    {
        $line = trim($line);

        foreach (TagNameEnum::cases() as $case) {
            if (stripos($line, $case->value) === 0) {
                return $case->getTag();
            }
        }

        if (str_starts_with($line, '#')) {
            return new CommentTag($line);
        }

        return new UrlTag($line);
    }

    public function removeTagString(string $line): string
    {
        $tagName = $this->tagName->value;

        if ($this->hasColonInName()) {
            $tagName .= ':';
        }

        if (str_starts_with($line, $tagName)) {
            return trim(substr($line, strlen($tagName)));
        }

        return $line;
    }
}
