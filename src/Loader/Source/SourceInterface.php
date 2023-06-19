<?php

namespace App\Loader\Source;

interface SourceInterface
{
    public function load(string $file): array;
}