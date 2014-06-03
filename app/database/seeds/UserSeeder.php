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
                "userGroup"=> 1, //1 administrators  //2  darba devējs  //3 darba meklētajs
                "active"   => 1,
                //"picture"  => "uploads/profileImages/gWCvpJ0E8lBn7WRBnGQGIPAkmeLwiE1398862400.jpeg",
                "prefLang" => "lv",
                "firstname"=> "Jānis",
                "lastname" => "Lielais",
                "about" => "",
            ],
            [
                "username" => "blake",
                "password" => Hash::make("blake"),
                "email"    => "test2@yopmail.com",
                "userGroup"=> 2,
                "active"   => 1,
                //"picture"  => "uploads/profileImages/gWCvpJ0E8lBn7WRBnGQGIPAkmeLwiE1398862400.jpeg",
                "prefLang" => "en",
                "firstname"=> "blake",
                "lastname" => "mcGuyver",
                "about" => "",
            ],
            [
                "username" => "peteris",
                "password" => Hash::make("peteris"),
                "email"    => "test3@yopmail.com",
                "userGroup"=> 3,
                "active"   => 1,
                //"picture"  => "uploads/profileImages/gWCvpJ0E8lBn7WRBnGQGIPAkmeLwiE1398862400.jpeg",
                "prefLang" => "",
                "firstname"=> "Pēteris",
                "lastname" => "Sarkanbārda",
                "about" => "",
            ],
        ];
        foreach ($users as $user)
        {
            User::create($user);
        }
    }
}