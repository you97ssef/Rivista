<?php

namespace App\Interfaces;

interface IMediaService {
    public function upload($file, string $type, bool $coded = false): ?array;
    public function remove(string $hash): bool;
}