<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class WishlistCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     */
    public function toArray($request): array
    {
        return [
            'data' => $this->collection->transform(function ($wishlist) {
                return [
                    'id' => $wishlist->id,
                    'name' => $wishlist->name,
                    'created_at' => $wishlist->created_at,
                    'products_count' => $wishlist->products_count,
                ];
            }),
        ];
    }
}
