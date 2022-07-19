<?php

namespace App\Http\Controllers;

use App\Http\Response;
use App\Interfaces\ICommentRepo;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    private $commentRepo;

    public function __construct(ICommentRepo $commentRepo)
    {
        $this->commentRepo = $commentRepo;
    }

    public function save()
    {
        if (Auth::check()) {
            $validatedData = request()->validate([
                'text' => 'required|string|max:255',
                'rivista_id' => 'required|integer',
            ]);

            $validatedData['user_id'] = Auth::user()->id;
        } else {
            $validatedData = request()->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'text' => 'required|string|max:255',
                'rivista_id' => 'required|integer',
            ]);
        }

        if ($this->commentRepo->save($comment = new Comment(), $validatedData))
            return Response::Created($comment);

        return Response::BadRequest('Could not create comment.');
    }

    public function delete($id)
    {
        if (!$comment = $this->commentRepo->get($id)) return Response::BadRequest('Comment not found.');

        if ($this->commentRepo->delete($comment))
            return Response::NoContent();

        return Response::BadRequest('Could not delete comment.');
    }
}
