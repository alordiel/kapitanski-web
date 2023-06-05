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

        Permission::create(['name' => 'upload-files']);
        Permission::create(['name' => 'delete-files']);

        Permission::create(['name' => 'create-posts']);
        Permission::create(['name' => 'edit-posts']);
        Permission::create(['name' => 'delete-posts']);

        Permission::create(['name' => 'create-products']);
        Permission::create(['name' => 'edit-products']);
        Permission::create(['name' => 'delete-products']);

        Permission::create(['name' => 'create-exams']);
        Permission::create(['name' => 'edit-exams']);
        Permission::create(['name' => 'delete-exams']);

        Permission::create(['name' => 'create-students']);
        Permission::create(['name' => 'edit-students']);
        Permission::create(['name' => 'delete-students']);

        Permission::create(['name' => 'take-exam']);

        Permission::create(['name' => 'view-students-statistics']);
        Permission::create(['name' => 'view-all-statistics']);


        $adminRole = Role::create(['name' => 'super-admin']);
        $activeMemberRole = Role::create(['name' => 'student']);
        $inactiveMemberRole = Role::create(['name' => 'member']);
        $partnerRole = Role::create(['name' => 'business-partner']);
        $studentPartnerRole = Role::create(['name' => 'student-partner']);

        $adminRole->givePermissionTo(Permission::all());
        $partnerRole->givePermissionTo(['create-students','view-students-statistics']);
        $studentPartnerRole->givePermissionTo(['take-exam',  'create-students',]);
        $activeMemberRole->givePermissionTo(['take-exam']);
        $inactiveMemberRole->givePermissionTo([]);

        $user1 = User::where('id', 1)->get();
        $user1[0]->assignRole('super-admin');
        $user2 = User::where('id', 2)->get();
        $user2[0]->assignRole('business-partner');
        $user3 = User::where('id', 3)->get();
        $user3[0]->assignRole('student');
    }
}
