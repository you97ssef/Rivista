<?php

namespace App\Data;

use App\Interfaces\IMediaRepo;
use App\Models\Media;

class MediaRepo implements IMediaRepo
{
    public function save(Media $media, array $data): bool
    {
        foreach ($data as $key => $value) {
            $media->$key = $value;
        }

        return $media->save();
    }

    public function delete(Media $media): bool
    {
        return $media->delete();
    }

    public function get(string $link): ?Media
    {
        return Media::where('link', $link)->first();
    }
}