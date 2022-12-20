<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function index(): ResourceCollection
    {
        $this->authorize('viewAny', User::class);

        return UserResource::collection(User::with('roles')->get());
    }
}
