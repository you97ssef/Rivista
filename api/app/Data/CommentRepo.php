<?php

namespace App\Data;

use App\Interfaces\ICommentRepo;
use App\Models\Comment;
use App\Models\Rivista;

class CommentRepo implements ICommentRepo
{
    public function rivisitas($id)
    {
        // TODO: get only some data to improve performance
        return Rivista::find($id)->comments;
    }

    public function save(Comment $comment, array $data): bool
    {
        if (array_key_exists('name', $data)) $comment->name = $data['name'];
        if (array_key_exists('email', $data)) $comment->email = $data['email'];
        if (array_key_exists('text', $data)) $comment->text = $data['text'];
        if (array_key_exists('user_id', $data)) $comment->user_id = $data['user_id'];
        if (array_key_exists('rivista_id', $data)) $comment->rivista_id = $data['rivista_id'];

        return $comment->save();
    }

    public function delete(Comment $comment): bool
    {
        return $comment->delete();
    }
}
