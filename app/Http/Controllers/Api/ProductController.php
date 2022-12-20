<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductController extends Controller
{
    public function index(): ResourceCollection
    {
        return ProductResource::collection(Product::all());
    }
}
