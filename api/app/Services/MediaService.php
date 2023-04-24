<?php

namespace App\Services;

use App\Interfaces\IMediaService;
use Illuminate\Support\Facades\Http;

class MediaService implements IMediaService {
    public function upload($file, string $type, bool $coded = false): ?array {
        $response = Http::withHeaders([
                'Authorization' => 'CLIENT-ID ' . env('IMGUR_CLIENT_ID'),
            ])->post('https://api.imgur.com/3/image', [
                $type => $coded ? $file : base64_encode(file_get_contents($file))
            ])->json();


        if ($response['success']) return [
            'link' => $response['data']['link'],
            'delete_hash' => $response['data']['deletehash']
        ];

        return null;
    }

    public function remove(string $hash): bool {
        $response = Http::withHeaders([
                'Authorization' => 'CLIENT-ID ' . env('IMGUR_CLIENT_ID'),
            ])
            ->delete("https://api.imgur.com/3/image/$hash")
            ->json();

        if ($response['success']) return true;

        return false;
    }
}