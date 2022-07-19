<?php

namespace App\Http\Controllers;

use App\Http\Response;
use App\Interfaces\ILikeRepo;
use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    private $likeRepo;

    public function __construct(ILikeRepo $likeRepo)
    {
        $this->likeRepo = $likeRepo;
    }

    public function like(Request $request)
    {
        $validatedData = $request->validate([
            'rivista_id' => 'required|integer',
        ]);

        $validatedData['user_id'] = $request->user()->id;

        if ($this->likeRepo->getByUserAndRivista($validatedData['user_id'], $validatedData['rivista_id'])) return Response::BadRequest('You already liked this rivista');

        if ($this->likeRepo->save($like = new Like(), $validatedData))
            return Response::Created($like);

        return Response::BadRequest('Could not like this rivista.');
    }

    public function unlike(Request $request, $id)
    {
        $validatedData = $request->validate([
            'rivista_id' => 'required|integer',
        ]);

        $validatedData['user_id'] = $request->user()->id;

        if (!$like = $this->likeRepo->getByUserAndRivista($validatedData['user_id'], $validatedData['rivista_id'])) return Response::BadRequest('You did not like this rivista');

        if ($this->likeRepo->delete($like))
            return Response::NoContent();

        return Response::BadRequest('Could not unlike this rivista.');
    }
}
