<?php

declare(strict_types=1);

namespace Akaramires\M3uParser\Traits;

use Akaramires\M3uParser\Dto\AttributeDto;
use Spatie\LaravelData\DataCollection;

trait AttributesTrait
{
    public function extractAttributes(string $string): DataCollection
    {
        preg_match_all('/([^=" ]+)=("(?:\\\"|[^"])*"|(?:\\\"|[^=" ])+)/', $string, $matches, PREG_SET_ORDER);

        return new DataCollection(
            AttributeDto::class,
            array_map(
                callback: fn(array $match) => new AttributeDto($match[1], $match[2]),
                array: $matches
            )
        );
    }
}
