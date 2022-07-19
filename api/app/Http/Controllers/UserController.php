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
            'password' => 'required|string|confirmed',
        ]);

        $user = $request->user();

        if(!Hash::check($validatedData['password'], $user->password)) return Response::BadRequest('Invalid password');

        if ($this->userRepo->save($user, $validatedData))
            return Response::NoContent();

        return Response::BadRequest('Could not update this user.');
    }

    public function changeRole(Request $request)
    {
        $validatedData = $request->validate([
            'role' => "required|string|in:${UserRole::ADMIN},${UserRole::USER}",
            'user_id' => 'required|integer',
        ]);

        if(!$user = $this->userRepo->get($validatedData['user_id'])) return Response::BadRequest('User not found');

        if ($this->userRepo->save($user, $validatedData))
            return Response::NoContent();

        return Response::BadRequest('Could not update this user.');
    }

    public function delete(Request $request)
    {
        $validatedData = $request->validate([
            'password' => 'required|integer',
        ]);

        $user = $request->user();

        if(!Hash::check($validatedData['password'], $user->password)) return Response::BadRequest('Invalid password');
        
        foreach ($user->tokens as $token) {
            $token->delete();
        }

        if ($this->userRepo->delete($user))
            return Response::NoContent();

        return Response::BadRequest('Could not delete this user.');
    }
}