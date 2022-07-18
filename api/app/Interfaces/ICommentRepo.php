<?php

namespace App\Interfaces;

use App\Models\Comment;

interface ICommentRepo
{
    public function rivisitas($id);

    public function save(Comment $comment, array $data): bool;

    public function delete(Comment $comment): bool;
}
