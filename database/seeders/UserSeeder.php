<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name'  => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123123123'),
            ],
            [
                'name'  => 'User',
                'email' => 'User@gmail.com',
                'password' => Hash::make('123123123'),
            ],
            
        ];
        foreach($users as $item){
            if(is_null(User::where('email' , $item['email'])->first()))
            User::firstOrCreate($item);
        }
    }
}
