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
                "user_id" => 1,
                "employer_id" => 2
            ],
            [
                "user_id" => 2,
                "employer_id" => 1
            ],
            [
                "user_id" => 6,
                "employer_id" => 7
            ],
            [
                "user_id" => 8,
                "employer_id" => 7
            ],
            [
                "user_id" => 9,
                "employer_id" => 7
            ],
        ];
        foreach ($recommendations as $recommendation)
        {
            Recommendation::create($recommendation);
        }
    }
}