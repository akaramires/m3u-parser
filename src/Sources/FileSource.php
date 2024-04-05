<?php

declare(strict_types=1);

namespace Akaramires\M3uParser\Sources;

use Akaramires\M3uParser\Exceptions\PlaylistIsEmptyException;
use Akaramires\M3uParser\Exceptions\PlaylistNotFoundException;

class FileSource extends BaseSource
{
    /**
     * {@inheritDoc}
     */
    public function validate(): void
    {
        if (!file_exists($this->source)) {
            throw new PlaylistNotFoundException();
        }

        if (filesize($this->source) === 0) {
            throw new PlaylistIsEmptyException();
        }
    }

    public function getContent(): string
    {
        return file_get_contents($this->source);
    }
}
