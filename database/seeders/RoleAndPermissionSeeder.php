<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use function Ramsey\Uuid\v1;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'create-posts']);
        Permission::create(['name' => 'edit-posts']);
        Permission::create(['name' => 'delete-posts']);

        Permission::create(['name' => 'create-products']);
        Permission::create(['name' => 'edit-products']);
        Permission::create(['name' => 'delete-products']);

        Permission::create(['name' => 'create-exams']);
        Permission::create(['name' => 'edit-exams']);
        Permission::create(['name' => 'delete-exams']);

        Permission::create(['name' => 'create-members']);
        Permission::create(['name' => 'edit-members']);
        Permission::create(['name' => 'delete-members']);

        Permission::create(['name' => 'take-exam']);

        Permission::create(['name' => 'view-members-statistics']);
        Permission::create(['name' => 'view-all-statistics']);


        $adminRole = Role::create(['name' => 'super-admin']);
        $activeMemberRole = Role::create(['name' => 'active-member']);
        $inactiveMemberRole = Role::create(['name' => 'suspended-member']);
        $partnerRole = Role::create(['name' => 'partner']);

        $adminRole->givePermissionTo(Permission::all());

        $partnerRole->givePermissionTo([
            'create-members',
            'view-members-statistics',
        ]);

        $activeMemberRole->givePermissionTo(['take-exam']);
        $inactiveMemberRole->givePermissionTo([]);

        $user1 = User::where('id', 1)->get();
        $user1[0]->assignRole('super-admin');
        $user2 = User::where('id', 2)->get();
        $user2[0]->assignRole('partner');
        $user3 = User::where('id', 3)->get();
        $user3[0]->assignRole('active-member');
    }
}