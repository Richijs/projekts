<?php
class VacancieSeeder
extends DatabaseSeeder
{
    public function run()
    {
        $vacancies = [
            [
                "name"      => "Looking for senior programmer",
                "company"   => "SIA xSIA",
                //"poster"    => "uploads/vacanciePosters/Iz8JpPtmeQptU6fDJQkVCY6pwrHcaM1398862788.jpg",
                "phone"     => "27628349",
                "text"      => "Looking for an experienced programmer\r\nwith a minimum of atleast 3 year experience",
                "creator_id"=> 2
            ],
            [
                "name"      => "Looking for a driver",
                "company"   => "SIA xSIA",
                //"poster"    => "uploads/vacanciePosters/Iz8JpPtmeQptU6fDJQkVCY6pwrHcaM1398862788.jpg",
                "phone"     => "276283429",
                "text"      => "Looking for a dedicated driver\r\nbus driver's lincence is required\r\nhourly pay",
                "creator_id"=> 2
            ],
            [
                "name"      => "Programmētājs/testētājs",
                "company"   => "AS 'klaviatūra'",
                //"poster"    => "uploads/vacanciePosters/Iz8JpPtmeQptU6fDJQkVCY6pwrHcaM1398862788.jpg",
                "phone"     => "27628349",
                "text"      => "programmētājs/testētājs\r\npilna slodze ar iespējamām virsstundām\r\nzvanīt no 12:00 līdz 18:00",
                "creator_id"=> 1
            ],
            [
                "name"      => "Picu piegādātājs",
                "company"   => "IK 'mcMC'",
                "poster"    => "uploads/vacanciePosters/nfiaD0AehDHUIFH2m6FVnDLBJutusp1401789113.jpg",
                "phone"     => "276258349",
                "text"      => "Meklē picu piegādātāju\r\nGabaldarba samaksa\r\nZvaniet vai piesakieties",
                "creator_id"=> 4
            ],
            [
                "name"      => "Svaigproduktu piegādātājs",
                "company"   => "IK 'mcMC'",
                "poster"    => "uploads/vacanciePosters/yAg3HUmaGdcgSSwqQybPVn7yJ3tFCh1401794756.jpg",
                "phone"     => "2768349",
                "text"      => "Meklē svaigproduktu piegādātāju\r\nGabaldarba samaksa\r\nZvaniet vai piesakieties",
                "creator_id"=> 6
            ],
            
        ];
        foreach ($vacancies as $vacancie)
        {
            Vacancie::create($vacancie);
        }
    }
}