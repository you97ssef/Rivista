<?php

namespace App\Data;

use App\Interfaces\IUserRepo;
use App\Models\Rivista;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
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
        return User::with(['rivistas' => function ($query) {
            $query->select('id', 'user_id', 'image', 'title', 'slug', 'created_at', 'updated_at', 'views');
            $query->selectRaw('SUBSTR(text, 0, 30) as text');
            $query->withcount('likes');
        }])->where('slug', $slug)->first();
    }

    // public function rivistas($id)
    // {
    //     return User::find($id)->rivistas;
    // }

    // public function likes($id)
    // {
    //     return User::find($id)->likes;
    // }

    // public function comments($id)
    // {
    //     return User::find($id)->comments;
    // }

    public function save(User $user, array $data): bool
    {
        if (array_key_exists('first_name', $data)) {
            $user->first_name = $data['first_name'];
            $user->slug = Str::slug($data['first_name'] . ' ' . $data['last_name'] . ' ' . Str::random(10));
        }
        if (array_key_exists('last_name', $data)) {
            $user->last_name = $data['last_name'];
            $user->slug = Str::slug($data['first_name'] . ' ' . $data['last_name'] . ' ' . Str::random(10));
        }
        if (array_key_exists('email', $data)) $user->email = $data['email'];
        if (array_key_exists('password', $data)) $user->password = Hash::make($data['password']);
        if (array_key_exists('image', $data)) $user->image = $data['image'];
        if (array_key_exists('role', $data)) $user->role = $data['role'];

        return $user->save();
    }

    public function delete(User $user): bool
    {
        return $user->delete();
    }

    public function views()
    {
        return Rivista::with('user')->selectRaw('user_id, SUM(views) as views')->groupBy('user_id')->orderBy('views', 'desc')->get();
    }

    public function likes()
    {
        return User::selectRaw('users.*, count(likes.id) as likes')
            ->leftJoin('rivistas', 'rivistas.user_id', '=', 'users.id')
            ->leftJoin('likes', 'rivistas.id', '=', 'likes.rivista_id')
            ->groupBy('users.id')->orderBy('likes', 'desc')->get();
    }
}
