<?php

namespace App\Data;

use App\Interfaces\ILikeRepo;
use App\Models\Like;
use App\Models\Rivista;

class LikeRepo implements ILikeRepo
{
    // public function rivisitas($id)
    // {
    //     // TODO: get only some data to improve performance
    //     return Rivista::find($id)->likes;
    // }

    public function save(Like $like, array $data): bool
    {
        $like->user_id = $data['user_id'];
        $like->rivista_id = $data['rivista_id'];

        return $like->save();
    }

    public function delete(Like $like): bool
    {
        return $like->delete();
    }

    public function getByUserAndRivista(int $userId, int $rivistaId): ?Like
    {
        return Like::where('user_id', $userId)->where('rivista_id', $rivistaId)->first();
    }
}
