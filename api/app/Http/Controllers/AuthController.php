<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Response;
use App\Interfaces\IUserRepo;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    private $userRepo;

    public function __construct(IUserRepo $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (!$user = $this->userRepo->getWithEmail($validatedData['email']))
            return Response::BadRequest('Invalid Email');

        if (!Hash::check($validatedData['password'], $user->password))
            return Response::BadRequest('Invalid Password');

        $responseData['token'] = $user->createToken('authToken')->plainTextToken;
        $responseData['user'] = $user;

        return Response::Ok($responseData);
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
        ]);

        $validatedData['role'] = UserRole::USER;
        $validatedData['views'] = 0;

        if ($this->userRepo->save($user = new User(), $validatedData)) {

            $user->sendEmailVerificationNotification();

            $responseData['token'] = $user->createToken('authToken')->plainTextToken;
            $responseData['user'] = $user;

            return Response::Created($responseData, 'Account created successfully');
        }

        return Response::BadRequest('Could not create this user.');
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return Response::NoContent();
    }

    public function resendEmailVerification(Request $request)
    {
        $user = $request->user();

        if ($user->email_verified_at !== null) return Response::BadRequest('Email is already verified');

        $request->user()->sendEmailVerificationNotification();

        return Response::Ok(null, 'Verification email sent successfully');
    }

    public function forgotPassword(Request $request)
    {
        $validated = $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($validated);

        return $status === Password::RESET_LINK_SENT
            ? Response::Ok(null, __($status))
            : Response::BadRequest(__($status));
    }

    public function resetPassword(Request $request)
    {
        $validated = $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset($validated, function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        });
        return $status === Password::PASSWORD_RESET
            ? Response::Ok(null, __($status))
            : Response::BadRequest(__($status));
    }

    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return Response::Ok(null, 'Email verified successfully');
    }
}
