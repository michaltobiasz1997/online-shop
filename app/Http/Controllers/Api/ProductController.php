<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function index(): ResourceCollection
    {
        $this->authorize('viewAny', Product::class);

        return ProductResource::collection(Product::all());
    }
}
