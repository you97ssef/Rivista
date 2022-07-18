<?php

namespace App\Interfaces;

use App\Models\Like;

interface ILikeRepo
{
    public function rivisitas($id);

    public function save(Like $like, array $data): bool;

    public function delete(Like $like): bool;
}
