<?php
class ApplicationSeeder
extends DatabaseSeeder
{
    public function run()
    {
        $applications = [
            [
                "user_id" => 3,
                "vacancie_id" => 1,
                "letter"    => "Im willing to apply this vacancie\r\nSince i have experience in this field\r\nI think I would be suitable for this job\r\n\r\nPeteris"
            ],
            [
                "user_id" => 3,
                "vacancie_id" => 3,
                "letter"    => "Vēlētos pieteikties šim darbam\r\nLūdzu izskatiet manu CV"
            ],
            
        ];
        foreach ($applications as $application)
        {
            Application::create($application);
        }
    }
}