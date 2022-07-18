<?php

namespace App\Interfaces;

use App\Models\User;

interface IUserRepo 
{
    public function all();
    public function get(int $id): ?User;
    public function getWithEmail(String $email): ?User;
    
    public function save(User $user, array $data): bool;
    
    public function delete(User $user): Bool;
}