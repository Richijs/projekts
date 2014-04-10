<?php
class UserSeeder
extends DatabaseSeeder
{
    public function run()
    {
        $users = [
            [
                "username" => "test",
                "password" => Hash::make("MaPasward"),
                "email"    => "test@yopmail.com"
            ]
        ];
        foreach ($users as $user)
        {
            User::create($user);
        }
    }
}