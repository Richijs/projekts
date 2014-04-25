<?php

//not yet needed

//use Illuminate\Support\MessageBag;

class HomeController extends BaseController {
        
    public function viewHome()
    {
        
        $vacancies = Vacancie::all();
        foreach ($vacancies as $vacancie)
        {
            $vacancie->applied = Application::where('vacancie_id',$vacancie->id)->count();
            
            $creator = User::where('id',$vacancie->creator_id)->first();
            $vacancie->creatorName = $creator->username;
        }
        //pirmās piecas top vakances  (Pēc visvairāk pieteikušo skaita)
        $topVacancies = $vacancies->sortBy('applied')->reverse()->take(5);
        
        
        return View::make("home",array('topVacancies'=>$topVacancies));
    }
}