<?php

declare(strict_types=1);

namespace Akaramires\M3uParser\Sources;

use Akaramires\M3uParser\Contracts\SourceContract;
use Akaramires\M3uParser\Exceptions\PlaylistIsEmptyException;
use Akaramires\M3uParser\Exceptions\PlaylistNotFoundException;

class FileSource implements SourceContract
{
    public function __construct(
        private readonly string $filePath
    ) {
    }

    public function validate(): void
    {
        if (!file_exists($this->filePath)) {
            throw new PlaylistNotFoundException();
        }

        if (filesize($this->filePath) === 0) {
            throw new PlaylistIsEmptyException();
        }
    }

    public function getContent(): string
    {
        if (($content = file_get_contents($this->filePath)) === false) {
            throw new PlaylistIsEmptyException();
        }

        $content = $this->removeBom($content);
        $content = $this->removeBlankLines($content);

        return $content;
    }

    public function removeBom(string $string): string
    {
        if (str_starts_with($string, "\xEF\xBB\xBF")) {
            $string = substr($string, 3);
        }

        return $string;
    }

    public function removeBlankLines(string $string): string
    {
        return preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $string);
    }
}
