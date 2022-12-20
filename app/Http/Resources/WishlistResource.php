<?php

namespace App\Http\Resources;

use App\Models\Wishlist;
use Illuminate\Http\Resources\Json\JsonResource;

class WishlistResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        /** @var Wishlist $this */
        return [
            'id' => $this->id,
            'name' => $this->name,
            'created_at' => $this->created_at,
            'products' => ProductResource::collection($this->products),
        ];
    }
}
