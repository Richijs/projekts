<?php
class UserSeeder
extends DatabaseSeeder
{
    public function run()
    {
        $users = [
            [
                "username" => "admin",
                "password" => Hash::make("adminadmin"),
                "email"    => "test1@yopmail.com",
                "userGroup"=> 1, //1 admins  //2  darba devejs  //3 darba mekletajs
                "active"   => 1,
                "firstname"=> "Adminos",
                "lastname" => "Magnificos"
            ],
            [
                "username" => "employer",
                "password" => Hash::make("employer"),
                "email"    => "test2@yopmail.com",
                "userGroup"=> 2,
                "active"   => 1,
                "firstname"=> "Employerus",
                "lastname" => "Magnificos"
            ],
            [
                "username" => "seeker",
                "password" => Hash::make("seeker"),
                "email"    => "test3@yopmail.com",
                "userGroup"=> 3,
                "active"   => 1,
                "firstname"=> "Seekerus",
                "lastname" => "Magnificos"
            ]
        ];
        foreach ($users as $user)
        {
            User::create($user);
        }
    }
}