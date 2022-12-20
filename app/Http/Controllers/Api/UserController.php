<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserController extends Controller
{
    public function index(): ResourceCollection
    {
        return UserResource::collection(User::with('roles')->get());
    }
}
