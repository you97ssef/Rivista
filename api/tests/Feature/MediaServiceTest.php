<?php

namespace Tests\Feature;

use App\Interfaces\IMediaService;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class MediaServiceTest extends TestCase
{
    private readonly IMediaService $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = app(IMediaService::class);
    }

    public function test_service()
    {
        $data = $this->service->upload('R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7', 'image');

        $this->assertTrue(isset($data['link']));
        $this->assertTrue(isset($data['delete_hash']));

        $this->assertTrue($this->service->remove($data['delete_hash']));
    }
}
