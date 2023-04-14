<?php

namespace App\Interfaces;

interface IMediaService {
    public function upload($file, string $type): ?array;
    public function remove(string $hash): bool;
}