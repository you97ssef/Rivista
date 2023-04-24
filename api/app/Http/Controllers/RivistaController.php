<?php

namespace App\Http\Controllers;

use App\Http\Response;
use App\Interfaces\ILikeRepo;
use App\Interfaces\IRivistaRepo;
use App\Models\Rivista;
use Illuminate\Http\Request;
use App\Interfaces\IMediaService;
use App\Interfaces\IMediaRepo;
use App\Models\Media;
use App\Enums\MediaType;
use DOMDocument;

/**
 * @group Rivista management
 *
 * APIs for managing Rivistas
 */
class RivistaController extends Controller
{
    private $rivistaRepo, $likeRepo, $mediaService, $mediaRepo;

    public function __construct(IRivistaRepo $rivistaRepo, ILikeRepo $likeRepo, IMediaService $mediaService, IMediaRepo $mediaRepo)
    {
        $this->rivistaRepo = $rivistaRepo;
        $this->likeRepo = $likeRepo;
        $this->mediaService = $mediaService;
        $this->mediaRepo = $mediaRepo;
    }

    /**
     * @unauthenticated
     */
    public function paginate()
    {
        return Response::Ok($this->rivistaRepo->paginate());
    }

    /**
     * @unauthenticated
     */
    public function getWithSlug(String $slug)
    {
        if (!$rivista = $this->rivistaRepo->getWithSlug($slug)) return Response::NotFound('Rivista not found');

        $data['views'] = $rivista->views + 1;

        $this->rivistaRepo->save($rivista, $data);

        if ($user = auth('sanctum')->user())
            $rivista->liked = $this->likeRepo->getByUserAndRivista($user->id, $rivista->id);

        return Response::Ok($rivista);
    }

    private function uploadImagesInHtml(String $html, string $oldHtml = '') 
    {
        $doc = new DOMDocument();
        $doc->loadHTML($html);

        $images = $doc->getElementsByTagName('img');

        if ($oldHtml != '') {
            $oldDoc = new DOMDocument();
            $oldDoc->loadHTML($oldHtml);

            $oldImages = $oldDoc->getElementsByTagName('img');

            foreach ($oldImages as $oldImage) {
                $oldSrc = $oldImage->getAttribute('src');
                $exist = false;

                foreach ($images as $newImage) {
                    $newSrc = $newImage->getAttribute('src');

                    if (filter_var($newSrc, FILTER_VALIDATE_URL)) {
                        if ($newSrc == $oldSrc) $exist = true;
                    }
                }
                
                if (!$exist) {
                    $media = $this->mediaRepo->get($oldSrc);
                        
                    if ($media) {
                        $this->mediaService->remove($media->delete_hash);
                        $this->mediaRepo->delete($media);
                    }
                }
            }
        }

        foreach ($images as $image) {
            $src = $image->getAttribute('src');
            
            if (!filter_var($src, FILTER_VALIDATE_URL)) {
                $data = explode(',', $src)[1];

                if (!$img = $this->mediaService->upload($data, MediaType::IMAGE, true)) return null;
                $img['type'] = MediaType::IMAGE;
                $this->mediaRepo->save(new Media(), $img);
    
                $image->setAttribute('src', $img['link']);
            }
        }

        return $doc->saveHTML();
    }

    public function new(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'text' => 'required|string',
            'category_id' => 'required|integer|exists:categories,id',
        ]);

        $validatedData['user_id'] = $request->user()->id;
        $validatedData['views'] = 0;
        if (!$validatedData['text'] = $this->uploadImagesInHtml($validatedData['text'])) return Response::BadRequest('Could not upload rivista check your inputs!');
        if ($this->rivistaRepo->save($rivista = new Rivista(), $validatedData))
            return Response::Created($rivista);

        return Response::BadRequest('Could not create this rivista.');
    }

    public function update($id, Request $request)
    {
        if (!$rivista = $this->rivistaRepo->get($id)) return Response::BadRequest('Rivista not found');

        if ($rivista->user_id != $request->user()->id) return Response::BadRequest('You are not the owner of this rivista');

        $validatedData = $request->validate([
            'title' => 'nullable|string',
            'slug' => 'nullable|string',
            'text' => 'nullable|string',
            'category_id' => 'nullable|integer|exists:categories,id',
        ]);

        if (!$validatedData['text'] = $this->uploadImagesInHtml($validatedData['text'], $rivista->text)) return Response::BadRequest('Could not upload rivista check your inputs!');
        if ($this->rivistaRepo->save($rivista, $validatedData))
            return Response::Ok($rivista);

        return Response::BadRequest('Could not update this rivista.');
    }

    public function delete($id, Request $request)
    {
        if (!$rivista = $this->rivistaRepo->get($id)) return Response::BadRequest('Rivista not found');

        if ($rivista->user_id != $request->user()->id) return Response::BadRequest('You are not the owner of this rivista');


        $doc = new DOMDocument();
        $doc->loadHTML($rivista->text);
        $images = $doc->getElementsByTagName('img');
        foreach ($images as $image) {
            $src = $image->getAttribute('src');
                        
            if ($media = $this->mediaRepo->get($src)) {
                $this->mediaService->remove($media->delete_hash);
                $this->mediaRepo->delete($media);
            }
        }

        if ($this->rivistaRepo->delete($rivista))
            return Response::NoContent();

        return Response::BadRequest('Could not delete this rivista.');
    }

    /**
     * @unauthenticated
     */
    public function views()
    {
        return Response::Ok($this->rivistaRepo->views());
    }

    /**
     * @unauthenticated
     */
    public function likes()
    {
        return Response::Ok($this->rivistaRepo->likes());
    }
}
