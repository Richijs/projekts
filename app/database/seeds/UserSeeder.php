<?php
class UserSeeder
extends DatabaseSeeder
{
    public function run()
    {
        $users = [
            [
                "username" => "admin",
                "password" => Hash::make("admin"),
                "email"    => "test1@yopmail.com",
                "userGroup"=> 1
            ],
            [
                "username" => "user",
                "password" => Hash::make("user"),
                "email"    => "test2@yopmail.com",
                "userGroup"=> 3
            ]
        ];
        foreach ($users as $user)
        {
            User::create($user);
        }
    }
}