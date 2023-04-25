<?php

namespace App\Http\Controllers;

use App\Enums\MediaType;
use App\Http\Response;
use App\Interfaces\ICategoryRepo;
use App\Interfaces\IMediaRepo;
use App\Interfaces\IMediaService;
use App\Interfaces\IRivistaRepo;
use App\Interfaces\IUserRepo;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MediaController extends Controller
{
    private $repo, $service, $rivistaRepo, $userRepo, $categoryRepo;

    public function __construct(IMediaRepo $repo, IMediaService $service, IRivistaRepo $rivistaRepo, IUserRepo $userRepo, ICategoryRepo $categoryRepo)
    {
        $this->repo = $repo;
        $this->service = $service;
        $this->rivistaRepo = $rivistaRepo;
        $this->userRepo = $userRepo;
        $this->categoryRepo = $categoryRepo;
    }

    public function upload(Request $request)
    {
        $validatedData = $request->validate([
            MediaType::IMAGE => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            MediaType::VIDEO => 'nullable|mimes:mp4,mov,avi'
        ]);

        $type = null;
        
        if ($validatedData[MediaType::IMAGE]) $type = MediaType::IMAGE;
        if ($validatedData[MediaType::VIDEO]) $type = MediaType::VIDEO;

        if ($type) {
            if($media = $this->service->upload($validatedData[$type], $type)){
                $media['type'] = $type;
                if($this->repo->save(new Media(), $media)) return Response::Ok($media, 'Media uploaded successfully');
            }
        }

        return Response::BadRequest('Could not upload media');
    }

    public function uploadRivista(Request $request) 
    {
        $validatedData = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'rivista' => 'required|numeric',
        ]);

        $rivista = $this->rivistaRepo->get($validatedData['rivista']);

        if ($rivista->user_id != $request->user()->id) return Response::Unauthorized('You are not authorized to upload media for this rivista.');

        if ($media = $this->service->upload($validatedData['image'], MediaType::IMAGE)) {
            $media['type'] = MediaType::IMAGE;
            
            if ($this->repo->save(new Media(), $media)) 
                if ($this->rivistaRepo->save($rivista, ['image' => $media['link']])) 
                    return Response::Ok(null, 'Media uploaded successfully');
        }
        
        return Response::BadRequest('Could not upload media');
    } 

    public function uploadProfile(Request $request)
    {
        $validatedData = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $user = $request->user();

        if ($media = $this->service->upload($validatedData['image'], MediaType::IMAGE)) {
            $media['type'] = MediaType::IMAGE;
            
            if ($this->repo->save(new Media(), $media)) 
                if ($this->userRepo->save($user, ['image' => $media['link']])) 
                    return Response::Ok($user, 'Media uploaded successfully');
        }
        
        return Response::BadRequest('Could not upload media');
    }

    public function uploadCategory(Request $request) 
    {
        $validatedData = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category' => 'required|string',
        ]);

        $category = $this->categoryRepo->get($validatedData['category']);

        if ($media = $this->service->upload($validatedData['image'], MediaType::IMAGE)) {
            $media['type'] = MediaType::IMAGE;
            
            if ($this->repo->save(new Media(), $media)) 
                if ($this->categoryRepo->save($category, ['image' => $media['link']])) 
                    return Response::Ok(null, 'Media uploaded successfully');
        }
        
        return Response::BadRequest('Could not upload media');
    } 

    public function deleteCategory($slug)
    {        
        $category = $this->categoryRepo->get($slug);

        if (isset($category->image)) {
            if ($media = $this->repo->get($category->image)) 
                if ($this->service->remove($media->delete_hash)) {
                    $this->repo->delete($media);
                }

            $this->categoryRepo->save($category, ['image' => null]);
            return Response::Ok(null, 'Image deleted successfully');
        } 

        return Response::BadRequest('Could not delete image');
    }

    public function deleteProfile(Request $request)
    {
        $user = $request->user();

        if ($user->image) {
            if ($media = $this->repo->get($user->image))
                if ($this->service->remove($media->delete_hash)) {
                    $this->userRepo->save($user, ['image' => null]);
                    $this->repo->delete($media);

                    return Response::Ok($user, 'Image deleted successfully');
                }
        }

        return Response::BadRequest('Could not delete image');
    }

    public function deleteRivista($id, Request $request)
    {
        $user = $request->user();
        
        $rivista = $this->rivistaRepo->get($id);

        if ($rivista->user_id != $user->id) return Response::Unauthorized('You are not authorized to delete this media.');
        
        if (isset($rivista->image)) {
            if ($media = $this->repo->get($rivista->image))
                if ($this->service->remove($media->delete_hash)) {
                    $this->rivistaRepo->save($rivista, ['image' => null]);
                    $this->repo->delete($media);
                    
                }

            $this->rivistaRepo->save($rivista, ['image' => null]); 
            return Response::Ok(null, 'Image deleted successfully');
        } 

        return Response::BadRequest('Could not delete image');
    }

    public function delete($request)
    {
        $validatedData = $request->validate([
            'link' => 'required|string'
        ]);

        if ($media = $this->repo->get($validatedData['link']))
            if ($this->service->remove($media->delete_hash)) {
                $this->repo->delete($media);

                return Response::Ok(null, 'Media deleted successfully');
            }

        return Response::BadRequest('Could not delete media');
    }
}
