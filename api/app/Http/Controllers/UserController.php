<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Response;
use App\Interfaces\IUserRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private $userRepo;

    public function __construct(IUserRepo $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'password' => 'required|string',
        ]);

        $user = $request->user();

        if (!Hash::check($validatedData['password'], $user->password)) return Response::BadRequest('Invalid password');

        unset($validatedData['password']);

        if ($this->userRepo->save($user, $validatedData))
            return Response::Ok($user);

        return Response::BadRequest('Could not update this user.');
    }

    public function changeRole(Request $request)
    {
        $validatedData = $request->validate([
            'role' => 'required|string|in:' . UserRole::ADMIN . ',' . UserRole::USER,
            'user_id' => 'required|integer',
        ]);

        if (!$user = $this->userRepo->get($validatedData['user_id'])) return Response::BadRequest('User not found');

        if ($user->id == 1) return Response::BadRequest('You cannot change the role of this user.');

        if ($this->userRepo->save($user, $validatedData))
            return Response::NoContent();

        return Response::BadRequest('Could not update this user.');
    }

    public function delete(Request $request)
    {
        $validatedData = $request->validate([
            'password' => 'required|string',
        ]);

        $user = $request->user();

        if (!Hash::check($validatedData['password'], $user->password)) return Response::BadRequest('Invalid password');

        foreach ($user->tokens as $token) {
            $token->delete();
        }

        if ($this->userRepo->delete($user))
            return Response::NoContent();

        return Response::BadRequest('Could not delete this user.');
    }

    public function get(Request $request)
    {
        return Response::Ok($request->user());
    }

    public function all()
    {
        return Response::Ok($this->userRepo->all());
    }

    public function getWithSlug($slug)
    {
        if (!$user = $this->userRepo->getWithSlug($slug)) return Response::BadRequest('User dose not exist');

        return Response::Ok($user);
    }
}
