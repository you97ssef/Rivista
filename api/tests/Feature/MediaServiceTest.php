<?php

namespace Tests\Feature;

use App\Interfaces\IMediaRepo;
use App\Interfaces\IMediaService;
use App\Models\Media;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class MediaServiceTest extends TestCase
{
    private readonly IMediaService $service;
    private readonly IMediaRepo $repo;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = app(IMediaService::class);
        $this->repo = app(IMediaRepo::class);
    }

    public function test_service()
    {
        $data = $this->service->upload('R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7', 'image');

        $this->assertTrue(isset($data['link']));
        $this->assertTrue(isset($data['delete_hash']));

        $this->assertTrue($this->service->remove($data['delete_hash']));
    }

    public function test_repo()
    {
        $data = [
            'link' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'delete_hash' => 'dQw4w9WgXcQ',
            'type' => 'video',
        ];

        $this->assertTrue($this->repo->save($media = new Media(), $data));
        $this->assertTrue(isset($media->id));

        $this->assertTrue($this->repo->delete($media));
    }
}
