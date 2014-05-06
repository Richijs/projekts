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
                "cv"    => "uploads/jobSeekerCVs/admin__CV__RQWjZL43ujQbgmBCiKN0NxSZnVXfKS1399363599.pdf",
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