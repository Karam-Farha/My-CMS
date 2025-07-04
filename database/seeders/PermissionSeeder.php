<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            [   
                'name' => 'dashboard_access',
            ],
            // users
            [   
                'name' => 'user_access',
            ],
            [   
                'name' => 'user_store',
            ],
            [   
                'name' => 'user_update',
            ],
            [   
                'name' => 'user_delete',
            ],
            [   
                'name' => 'user_show',
            ],
        ];
        foreach($permissions as $item){
            Permission::firstOrCreate(['name' => $item['name']]);
        }
        
    }
}
