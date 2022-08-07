<?php

namespace App\Interfaces;

use App\Models\User;

interface IUserRepo
{
    public function all();
    public function get(int $id): ?User;
    public function getWithEmail(String $email): ?User;
    public function getWithSlug(String $slug): ?User;

    // public function rivistas($id);
    // public function likes($id);
    // public function comments($id);

    public function save(User $user, array $data): bool;

    public function delete(User $user): Bool;

    public function views();
    public function likes();
}
