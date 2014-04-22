<?php

//not yet needed

//use Illuminate\Support\MessageBag;

class VacanciesController extends BaseController {
        
    public function viewAllAction()
    {
        $vacanciesCount = Vacancie::all();
        if($vacanciesCount->count()){ //ja ir vismaz viens vacancy
            $vacancies = Vacancie::paginate(10); //all users + paginate

            return View::make("vacancies/viewAllVacancies", array('vacancies'=> $vacancies));
        }else{
            return View::make("vacancies/ViewAllVacancies");
        }
    }
}