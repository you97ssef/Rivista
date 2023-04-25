<?php

namespace App\Interfaces;

use App\Models\Media;

interface IMediaRepo
{
    public function get(string $link): ?Media;
    public function save(Media $media, array $data): bool;
    public function delete(Media $media): bool;
}