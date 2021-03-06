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
            [
                "user_id" => 3,
                "employer_id" => 4
            ],
            [
                "user_id" => 1,
                "employer_id" => 4
            ],
            [
                "user_id" => 2,
                "employer_id" => 1
            ],
            [
                "user_id" => 5,
                "employer_id" => 4
            ],
            [
                "user_id" => 5,
                "employer_id" => 1
            ],
            [
                "user_id" => 1,
                "employer_id" => 6
            ],
        ];
        foreach ($recommendations as $recommendation)
        {
            Recommendation::create($recommendation);
        }
    }
}