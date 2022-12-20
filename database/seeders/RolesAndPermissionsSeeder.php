<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $usersViewAny = Permission::findOrCreate('users.viewAny');

        $productsViewAny = Permission::findOrCreate('products.viewAny');

        $wishlistsViewAny = Permission::findOrCreate('wishlists.viewAny');
        $wishlistsView = Permission::findOrCreate('wishlists.view');
        $wishlistsCreate = Permission::findOrCreate('wishlists.create');
        $wishlistsUpdate = Permission::findOrCreate('wishlists.update');
        $wishlistsDelete = Permission::findOrCreate('wishlists.delete');
        $wishlistsClear = Permission::findOrCreate('wishlists.clear');
        $wishlistsProductsAttach = Permission::findOrCreate('wishlists.products.attach');
        $wishlistsProductsDetach = Permission::findOrCreate('wishlists.products.detach');

        /** @var Role $adminRole */
        $adminRole = Role::findOrCreate('admin');
        $adminRole->givePermissionTo(Permission::all());

        /** @var Role $customerRole */
        $customerRole = Role::findOrCreate('customer');
        $customerRole->givePermissionTo([
            $wishlistsViewAny,
            $wishlistsView,
            $wishlistsCreate,
            $wishlistsUpdate,
            $wishlistsDelete,
            $wishlistsClear,
            $wishlistsProductsAttach,
            $wishlistsProductsDetach,
        ]);
    }
}
