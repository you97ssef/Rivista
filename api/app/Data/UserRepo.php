<?php

namespace App\Data;

use App\Interfaces\IUserRepo;
use App\Models\User;
use Illuminate\Support\Str;

class UserRepo implements IUserRepo
{
    public function all()
    {
        return User::all();
    }

    // TODO refactor or better performance
    public function get(int $id): ?User
    {
        return User::find($id);
    }

    public function getWithEmail(String $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function getWithSlug(String $slug): ?User
    {
        return User::where('slug', $slug)->first();
    }

    public function rivistas($id)
    {
        return User::find($id)->rivistas;
    }

    public function likes($id)
    {
        return User::find($id)->likes;
    }

    public function comments($id)
    {
        return User::find($id)->comments;
    }

    public function save(User $user, array $data): bool
    {
        if (array_key_exists('first_name', $data)) {
            $user->first_name = $data['first_name'];
            $user->slug = Str::slug($data['first_name'] . ' ' . $data['last_name']);
        }
        if (array_key_exists('last_name', $data)) {
            $user->last_name = $data['last_name'];
            $user->slug = Str::slug($data['first_name'] . ' ' . $data['last_name']);
        }
        if (array_key_exists('email', $data)) $user->email = $data['email'];
        if (array_key_exists('password', $data)) $user->password = $data['password'];
        if (array_key_exists('image', $data)) $user->image = $data['image'];
        if (array_key_exists('role', $data)) $user->role = $data['role'];

        return $user->save();
    }

    public function delete(User $user): bool
    {
        return $user->delete();
    }
}