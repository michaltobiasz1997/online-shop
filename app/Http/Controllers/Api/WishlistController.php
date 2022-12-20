<?php

namespace App\Http\Controllers\Api;

use App\Actions\Wishlist\AttachProductAction;
use App\Actions\Wishlist\ClearWishlistAction;
use App\Actions\Wishlist\CreateWishlistAction;
use App\Actions\Wishlist\DetachProductAction;
use App\Actions\Wishlist\UpdateWishlistAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\WishlistRequest;
use App\Http\Resources\WishlistCollection;
use App\Http\Resources\WishlistResource;
use App\Models\Product;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function index(): WishlistCollection
    {
        $this->authorize('viewAny', Wishlist::class);

        /** @var User $user */
        $user = Auth::user();

        $wishlists = Wishlist::query()
            ->when(!$user->hasRole('admin'), function (Builder $query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->withCount('products')
            ->get();

        return new WishlistCollection($wishlists);
    }

    /**
     * @throws AuthorizationException
     */
    public function show(Wishlist $wishlist): WishlistResource
    {
        $this->authorize('view', $wishlist);

        return new WishlistResource($wishlist->load('products'));
    }

    /**
     * @throws AuthorizationException
     */
    public function store(WishlistRequest $request, CreateWishlistAction $createWishlistAction): WishlistResource
    {
        $this->authorize('create', Wishlist::class);

        $wishlist = $createWishlistAction($request->validated());

        return new WishlistResource($wishlist);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(WishlistRequest $request, Wishlist $wishlist, UpdateWishlistAction $updateWishlistAction): WishlistResource
    {
        $this->authorize('update', $wishlist);

        $wishlist = $updateWishlistAction($wishlist, $request->validated());

        return new WishlistResource($wishlist);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(Wishlist $wishlist): HttpResponse
    {
        $this->authorize('delete', $wishlist);

        $wishlist->delete();

        return response()->noContent();
    }

    /**
     * @throws AuthorizationException
     */
    public function clear(Wishlist $wishlist, ClearWishlistAction $clearWishlistAction): WishlistResource
    {
        $this->authorize('clear', $wishlist);

        $wishlist = $clearWishlistAction($wishlist);

        return new WishlistResource($wishlist);
    }

    /**
     * @throws AuthorizationException
     */
    public function attachProduct(Wishlist $wishlist, Product $product, AttachProductAction $attachProductAction): WishlistResource
    {
        $this->authorize('attachProduct', [$wishlist, $product]);

        $wishlist = $attachProductAction($wishlist, $product);

        return new WishlistResource($wishlist);
    }

    /**
     * @throws AuthorizationException
     */
    public function detachProduct(Wishlist $wishlist, Product $product, DetachProductAction $detachProductAction): WishlistResource
    {
        $this->authorize('detachProduct', $wishlist);

        $wishlist = $detachProductAction($wishlist, $product);

        return new WishlistResource($wishlist);
    }
}
