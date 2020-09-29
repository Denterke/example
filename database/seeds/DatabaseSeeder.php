<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'surname'       => 'Иванов',
            'name'          => 'Иван',
            'patronymic'    => 'Иванович',
            'city'          => 'Владивосток',
            'company'       => 'PTF',
            'email'         => 'user@user.com',
            'password'      => Hash::make('user_password'),
            'role'          => 1,
            'is_verified'   => 1
        ]);

        User::create([
            'surname'       => 'Иванов',
            'name'          => 'Иван',
            'patronymic'    => 'Иванович',
            'city'          => 'Владивосток',
            'company'       => 'PTF',
            'email'         => 'admin@admin.com',
            'password'      => Hash::make('admin_password'),
            'role'          => 2,
            'is_verified'   => 1
        ]);

        User::create([
            'surname'       => 'Иванов',
            'name'          => 'Иван',
            'patronymic'    => 'Иванович',
            'city'          => 'Владивосток',
            'company'       => 'PTF',
            'email'         => 'moderator@moderator.com',
            'password'      => Hash::make('moderator_password'),
            'role'          => 3,
            'is_verified'   => 1
        ]);
    }
}
