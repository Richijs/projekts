<?php
class VacancieSeeder
extends DatabaseSeeder
{
    public function run()
    {
        $vacancies = [
            [
                "name"      => "LF senior programmer",
                "company"   => "SIA ASIa",
                //"poster"    => "uploads/vacanciePosters/Iz8JpPtmeQptU6fDJQkVCY6pwrHcaM1398862788.jpg",
                "phone"     => "27628349",
                "text"      => "Looking for an experienced programmer\r\nwith a minimum of atleast 3 year experience\r\nCplasplas is considered a bonus\r\nwe will be waiting",
                "creator_id"=> 2
            ],
            [
                "name"      => "LF gardener",
                "company"   => "SIA ASusa",
                //"poster"    => "uploads/vacanciePosters/Iz8JpPtmeQptU6fDJQkVCY6pwrHcaM1398862788.jpg",
                "phone"     => "276283429",
                "text"      => "Looking for a gardener\r\nwith or without experience\r\n\r\nwe will be waiting",
                "creator_id"=> 2
            ],
            [
                "name"      => "alfonso AS meklē zirgu",
                "company"   => "alfonso AS",
                //"poster"    => "uploads/vacanciePosters/Iz8JpPtmeQptU6fDJQkVCY6pwrHcaM1398862788.jpg",
                "phone"     => "27628349",
                "text"      => "meklējam zirgu\r\npastāvīgam darbam\r\npilna vai nepilna laika slodze",
                "creator_id"=> 2
            ],
            [
                "name"      => "alfonso AS meklē namdari",
                "company"   => "alfonso AS",
                //"poster"    => "uploads/vacanciePosters/Iz8JpPtmeQptU6fDJQkVCY6pwrHcaM1398862788.jpg",
                "phone"     => "276258349",
                "text"      => "Nepieciešams pilna laika namdaris ar vismaz 3 gadu pieredzi\r\nstudentiem neatbildēt",
                "creator_id"=> 7
            ],
        ];
        foreach ($vacancies as $vacancie)
        {
            Vacancie::create($vacancie);
        }
    }
}