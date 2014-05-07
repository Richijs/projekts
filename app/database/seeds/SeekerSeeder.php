<?php
class SeekerSeeder
extends DatabaseSeeder
{
    public function run()
    {
        $seekers = [
            [
                "intro" => "Professional programmer looking for job",
                "text" => "Summary:\r\n2 year experience with assemly languages\r\n4 year php programmer",
                "cv"    => "uploads/jobSeekerCVs/admin__CV__vFYkyPIwTGpQ54R0rc4gjGIqHGSD7Z1399359091.pdf",
                "phone"=> 285239585,
                "user_id"   => 3
            ],
            [
                "intro" => "Professional freelancer",
                "text" => "Im a legit freelancer willing to join part time job\r\nI can solve android-ish puzzles with minimal effort",
                "cv"    => "uploads/jobSeekerCVs/admin__CV__vFYkyPIwTGpQ54R0rc4gjGIqHGSD7Z1399359091.pdf",
                "phone"=> 28523979585,
                "user_id"   => 9
            ],
        ];
        foreach ($seekers as $seeker)
        {
            Seeker::create($seeker);
        }
    }
}