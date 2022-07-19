<?php

namespace App\Http\Controllers;

use App\Interfaces\IUserRepo;

class UserController extends Controller
{
    private $userRepo;

    public function __construct(IUserRepo $userRepo)
    {
        $this->userRepo = $userRepo;
    }
}