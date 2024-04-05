<?php

declare(strict_types=1);

namespace Akaramires\M3uParser\Contracts;

use Akaramires\M3uParser\Exceptions\PlaylistIsEmptyException;
use Akaramires\M3uParser\Exceptions\PlaylistNotFoundException;

interface SourceContract
{
    /**
     * @throws PlaylistNotFoundException
     * @throws PlaylistIsEmptyException
     */
    public function validate(): void;

    public function getContent(): string;
}
