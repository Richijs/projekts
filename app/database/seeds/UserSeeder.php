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
                "userGroup"=> 1, //1 prostais cilv //2 darba devejs
                "status"   => 1
            ],
            [
                "username" => "user",
                "password" => Hash::make("user"),
                "email"    => "test2@yopmail.com",
                "userGroup"=> 3, //3 admin
                "status"   => 1
            ]
        ];
        foreach ($users as $user)
        {
            User::create($user);
        }
    }
}