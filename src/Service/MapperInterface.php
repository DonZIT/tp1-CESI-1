<?php

declare(strict_types=1);

namespace App\Service;

interface MapperInterface
{
    public function map(object $source, object $target): void;
}
