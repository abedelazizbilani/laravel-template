<?php

use App\Models\User;
use App\Models\Profile;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Admin
        $admin = new User();
        $admin->id = 1;
        $admin->email = 'admin@gmail.com';
        $admin->password = Hash::make('admin_123');
        $admin->name = 'admin';
        $admin->username = 'admin@gmail.com';
        $admin->active = 1;
        $admin->save();

        Profile::create(
            [
                'user_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        );

        //external
        $admin = new User();
        $admin->id = 2;
        $admin->email = 'test@example.com';
        $admin->password = Hash::make('example_123');
        $admin->name = 'Test User';
        $admin->username = 'test@example.com';
        $admin->active = 1;
        $admin->save();

        Profile::create(
            [
                'user_id' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        );

        //roles
        $roleUser = [
            ['user_id' => '1', 'role_id' => '1'],
            ['user_id' => '2', 'role_id' => '2']
        ];
        \App\Models\RoleUser::insert($roleUser);

    }
}
