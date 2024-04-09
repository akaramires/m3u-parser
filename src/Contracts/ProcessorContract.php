<?php

declare(strict_types=1);

namespace Akaramires\M3uParser\Contracts;

use Akaramires\M3uParser\Exceptions\PlaylistIsEmptyException;
use Akaramires\M3uParser\Exceptions\PlaylistNotFoundException;

interface ProcessorContract
{
    /**
     * @throws PlaylistIsEmptyException
     * @throws PlaylistNotFoundException
     */
    public function load(SourceContract $source): self;

    /**
     * @throws PlaylistIsEmptyException
     */
    public function parse(): self;
}
