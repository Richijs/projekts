<?php
class RecommendationSeeder
extends DatabaseSeeder
{
    public function run()
    {
        $recommendations = [
            [
                "user_id" => 3,
                "employer_id" => 2
            ],
            
        ];
        foreach ($recommendations as $recommendation)
        {
            Recommendation::create($recommendation);
        }
    }
}