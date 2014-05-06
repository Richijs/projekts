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
                "picture"  => "uploads/profileImages/gWCvpJ0E8lBn7WRBnGQGIPAkmeLwiE1398862400.jpeg",
                "prefLang" => "lv",
                "firstname"=> "Adminos",
                "lastname" => "Magnificos"
            ],
            [
                "username" => "employer",
                "password" => Hash::make("employer"),
                "email"    => "test2@yopmail.com",
                "userGroup"=> 2,
                "active"   => 1,
                "picture"  => "uploads/profileImages/gWCvpJ0E8lBn7WRBnGQGIPAkmeLwiE1398862400.jpeg",
                "prefLang" => "en",
                "firstname"=> "Employerus",
                "lastname" => "Magnificos"
            ],
            [
                "username" => "seeker",
                "password" => Hash::make("seeker"),
                "email"    => "test3@yopmail.com",
                "userGroup"=> 3,
                "active"   => 1,
                "picture"  => "uploads/profileImages/gWCvpJ0E8lBn7WRBnGQGIPAkmeLwiE1398862400.jpeg",
                "prefLang" => "lv",
                "firstname"=> "Seekerus",
                "lastname" => "Magnificos"
            ],
            [
                "username" => "inactiveguy",
                "password" => Hash::make("inactiveguy"),
                "email"    => "test4@yopmail.com",
                "userGroup"=> 3,
                "active"   => 1,
                "picture"  => "uploads/profileImages/gWCvpJ0E8lBn7WRBnGQGIPAkmeLwiE1398862400.jpeg",
                "prefLang" => "en",
                "firstname"=> "Inactivus",
                "lastname" => "Magnificuass"
            ],
            [
                "username" => "adminus",
                "password" => Hash::make("adminus"),
                "email"    => "test5@yopmail.com",
                "userGroup"=> 1,
                "active"   => 0,
                "picture"  => "uploads/profileImages/gWCvpJ0E8lBn7WRBnGQGIPAkmeLwiE1398862400.jpeg",
                "prefLang" => "en",
                "firstname"=> "InactivusAdminus",
                "lastname" => "Magnificuass"
            ],
            [
                "username" => "adminirium",
                "password" => Hash::make("adminirium"),
                "email"    => "test6@yopmail.com",
                "userGroup"=> 1,
                "active"   => 1,
                "picture"  => "uploads/profileImages/gWCvpJ0E8lBn7WRBnGQGIPAkmeLwiE1398862400.jpeg",
                "prefLang" => "lv",
                "firstname"=> "Žuļiks",
                "lastname" => "Zupahs"
            ],
            [
                "username" => "employzors",
                "password" => Hash::make("employzors"),
                "email"    => "test7@yopmail.com",
                "userGroup"=> 2,
                "active"   => 1,
                "picture"  => "uploads/profileImages/gWCvpJ0E8lBn7WRBnGQGIPAkmeLwiE1398862400.jpeg",
                "prefLang" => "en",
                "firstname"=> "Emahsf",
                "lastname" => "Emanuel"
            ],
            [
                "username" => "jobseeka",
                "password" => Hash::make("jobseeka"),
                "email"    => "test8@yopmail.com",
                "userGroup"=> 3,
                "active"   => 1,
                "picture"  => "uploads/profileImages/gWCvpJ0E8lBn7WRBnGQGIPAkmeLwiE1398862400.jpeg",
                "prefLang" => "en",
                "firstname"=> "Farzoar",
                "lastname" => "Fuamanuel"
            ],
            [
                "username" => "victor",
                "password" => Hash::make("victor"),
                "email"    => "test9@yopmail.com",
                "userGroup"=> 3,
                "active"   => 1,
                "picture"  => "uploads/profileImages/gWCvpJ0E8lBn7WRBnGQGIPAkmeLwiE1398862400.jpeg",
                "prefLang" => "lv",
                "firstname"=> "Viktors",
                "lastname" => "Siksnors"
            ]
            
        ];
        foreach ($users as $user)
        {
            User::create($user);
        }
    }
}