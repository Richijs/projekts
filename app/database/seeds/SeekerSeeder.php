<?php
class SeekerSeeder
extends DatabaseSeeder
{
    public function run()
    {
        $seekers = [
            [
                "intro" => "Meklēju jebkādu darbu",
                "text" => "Īsumā:\r\n2 gadu pieredze mehānikā\r\n2 gadu pieredze programmu testēšanā",
                "cv"    => "uploads/jobSeekerCVs/peteris__CV__vFYkyPIwTGpQ54R0rc4gjGIqHGSD7Z1399359091.pdf",
                "phone"=> 285239585,
                "user_id"   => 3
            ],
            
        ];
        foreach ($seekers as $seeker)
        {
            Seeker::create($seeker);
        }
    }
}