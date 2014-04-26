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
        
        
        
        
        $employers = User::where('userGroup','<>',3)->get();
        
        foreach($employers as $employer){
          
            $employer->recommendations = Recommendation::where('employer_id',$employer->id)->count();
            
        }
              
        $topEmployers = $employers->sortBy('recommendations')->reverse()->take(5);
        
        return View::make("home",array('topVacancies'=>$topVacancies,'topEmployers'=>$topEmployers));
    }
}