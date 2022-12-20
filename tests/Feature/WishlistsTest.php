<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WishlistsTest extends TestCase
{
    use RefreshDatabase;

    public function test_returns_wishlists_list()
    {
        /** @var Wishlist $wishlist1 */
        $wishlist1 = Wishlist::factory()->create([
            'user_id' => $this->user->id,
        ]);
        /** @var Wishlist $wishlist2 */
        $wishlist2 = Wishlist::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $response = $this->actingAs($this->user)->getJson('/api/wishlists');

        $response->assertJsonFragment([
            'name' => $wishlist1->name,
        ]);

        $response->assertJsonCount(2, 'data');
    }

    public function test_wishlist_store_successful()
    {
        $wishlist = [
            'name' => 'Favourites',
        ];

        $response = $this->actingAs($this->user)->postJson('/api/wishlists', $wishlist);

        $response->assertCreated();
        $response->assertSuccessful();
        $response->assertJsonFragment([
            'name' => 'Favourites',
        ]);
    }

    public function test_wishlist_invalid_store_returns_error()
    {
        $wishlist = [
            'name' => '',
        ];

        $response = $this->actingAs($this->user)->postJson('/api/wishlists', $wishlist);

        $response->assertUnprocessable();
        $response->assertInvalid('name');
    }

    public function test_wishlist_show_successful()
    {
        $wishlistData = [
            'name' => 'My wishlist',
        ];

        /** @var Wishlist $wishlist */
        $wishlist = $this->user->wishlists()->create($wishlistData);

        $response = $this->actingAs($this->user)->getJson('/api/wishlists/' . $wishlist->id);
        $response->assertOk();
        $response->assertJsonPath('data.name', $wishlistData['name']);
        $response->assertJsonMissingPath('data.products_count');
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'created_at',
                'products',
            ]
        ]);
    }

    public function test_wishlist_update_successful()
    {
        $wishlistData = [
            'name' => 'Gift for mom',
        ];

        /** @var Wishlist $wishlist */
        $wishlist = $this->user->wishlists()->create($wishlistData);

        $response = $this->actingAs($this->user)->putJson('/api/wishlists/' . $wishlist->id, [
            'name' => 'Gift for parents',
        ]);

        $response->assertOk();
        $response->assertJsonMissing($wishlistData);
    }

    public function test_wishlist_delete_logged_in_admin()
    {
        /** @var Wishlist $wishlist */
        $wishlist = Wishlist::factory()->create();

        $response = $this->actingAs($this->admin)->deleteJson('/api/wishlists/' . $wishlist->id);

        $response->assertNoContent();

        $this->assertDatabaseMissing('wishlists', $wishlist->toArray());
    }

    public function test_wishlist_show_restricted_by_other()
    {
        $wishlistData = [
            'name' => 'Favourites products',
        ];

        /** @var Wishlist $wishlist */
        $wishlist = $this->user->wishlists()->create($wishlistData);

        $response = $this->actingAs($this->secondUser)->getJson('/api/wishlists/' . $wishlist->id);

        $response->assertForbidden();
    }

    public function test_product_attach_successful()
    {
        $wishlistData = [
            'name' => 'My wishlist',
        ];

        /** @var Wishlist $wishlist */
        $wishlist = $this->user->wishlists()->create($wishlistData);

        /** @var Product $product */
        $product = Product::factory()->create();

        $response = $this->actingAs($this->user)->postJson('/api/wishlists/' . $wishlist->id . '/products/' . $product->id . '/attach');

        $response->assertSuccessful();

        $this->assertDatabaseHas('product_wishlist', [
            'product_id' => $product->id,
            'wishlist_id' => $wishlist->id,
            'sequence' => 1,
        ]);
    }

    public function test_product_detach_successful()
    {
        $wishlistData = [
            'name' => 'My wishlist',
        ];

        /** @var Wishlist $wishlist */
        $wishlist = $this->user->wishlists()->create($wishlistData);

        /** @var Product $product */
        $product = Product::factory()->create();

        $wishlist->products()->attach($product);

        $response = $this->actingAs($this->user)->deleteJson('/api/wishlists/' . $wishlist->id . '/products/' . $product->id . '/detach');

        $response->assertSuccessful();

        $this->assertSoftDeleted('product_wishlist', [
            'product_id' => $product->id,
            'wishlist_id' => $wishlist->id,
            'sequence' => 1,
        ]);
    }
}
