<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name' , 'Admin')->first();
        $adminUser = User::where('email' , 'admin@gmail.com')->first();
        $adminUser->roles()->sync($adminRole->id);


        $userRole = Role::where('name' , 'User')->first();
        $user = User::where('email' , 'user@gmail.com')->first();
        $user->roles()->sync($userRole->id);
    }
}
