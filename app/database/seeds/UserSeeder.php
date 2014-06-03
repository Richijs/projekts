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
                "picture"  => "uploads/profileImages/POWJK4IjVmbEEACAKkiFdYJzzmfsrU1401788665.jpg",
                "prefLang" => "lv",
                "firstname"=> "Jānis",
                "lastname" => "Lielais",
                "about" => "Administrēju saitu....",
            ],
            [
                "username" => "blake",
                "password" => Hash::make("blakeblake"),
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
                "picture"  => "uploads/profileImages/QxIr6Lba7XfSFxLIGdZLGJO4hcb2rZ1401786101.jpeg",
                "prefLang" => "lv",
                "firstname"=> "Pēteris",
                "lastname" => "Sarkanbārda",
                "about" => "izmisīgs darba meklētājs",
            ],
            [
                "username" => "chester",
                "password" => Hash::make("chester"),
                "email"    => "test4@yopmail.com",
                "userGroup"=> 2,
                "active"   => 1,
                "picture"  => "uploads/profileImages/0eh3CN5SKNqA93WCfpGv7sKTKCM5Zt1401788527.jpg",
                "prefLang" => "en",
                "firstname"=> "Chester",
                "lastname" => "McDonald",
                "about" => "",
            ],
            [
                "username" => "zivtina",
                "password" => Hash::make("zivtina"),
                "email"    => "test5@yopmail.com",
                "userGroup"=> 3,
                "active"   => 1,
                //"picture"  => "uploads/profileImages/QxIr6Lba7XfSFxLIGdZLGJO4hcb2rZ1401786101.jpeg",
                "prefLang" => "lv",
                "firstname"=> "Lauma",
                "lastname" => "Skarbā",
                "about" => "garšo tomāti un patīk garas pastaigas",
            ],
            [
                "username" => "doktors",
                "password" => Hash::make("doktors"),
                "email"    => "test6@yopmail.com",
                "userGroup"=> 2,
                "active"   => 1,
                "picture"  => "uploads/profileImages/3SNRbAzzKjFfC7fEZSVAnSYyuHwqCJ1401794568.gif",
                "prefLang" => "en",
                "firstname"=> "Doctor",
                "lastname" => "Proper",
                "about" => "",
            ],
        ];
        foreach ($users as $user)
        {
            User::create($user);
        }
    }
}