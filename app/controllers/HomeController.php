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
        //pirmie pieci top employeri (pēc visvairāk rekomendētā)
        $topEmployers = $employers->sortBy('recommendations')->reverse()->take(5);
        
        return View::make("home",array('topVacancies'=>$topVacancies,'topEmployers'=>$topEmployers));
    }
    
    public function searchAction()
    {
        
        if (Input::server("REQUEST_METHOD") == "GET"){
            return Redirect::route("home");
        }
        
        $search = Input::get('search');
 
        if(!$search){

            return View::make('search'); //pass nothing
        }
        
        $users = DB::table('users')
            ->where(function($query) use ($search)
            {
                $query->where('username', 'LIKE',  '%' . $search . '%')
                ->orWhere('about', 'LIKE',  '%' . $search . '%')
                ->orWhere('firstname', 'LIKE',  '%' . $search . '%')
                ->orWhere('lastname', 'LIKE',  '%' . $search . '%')
                ->where('created_at','>=', DB::raw('CURDATE()'));
            })
        ->orderBy('created_at', 'DESC')
        ->get();
            
            
        $vacancies = DB::table('vacancies')
            ->where(function($query) use ($search)
            {
                $query->where('name', 'LIKE',  '%' . $search . '%')
                ->orWhere('company', 'LIKE',  '%' . $search . '%')
                ->orWhere('text', 'LIKE',  '%' . $search . '%')
                ->where('created_at','>=', DB::raw('CURDATE()'));
            })
        ->orderBy('created_at', 'DESC')
        ->get();
            
            
        if(Auth::check() && Auth::user()->userGroup!=3)  
        {
        $seekers = DB::table('seekers')
            ->where(function($query) use ($search)
            {
                $query->where('intro', 'LIKE',  '%' . $search . '%')
                ->orWhere('text', 'LIKE',  '%' . $search . '%')
                ->where('created_at','>=', DB::raw('CURDATE()'));
            })
        ->orderBy('created_at', 'DESC')
        ->get();
            
            return View::make('search', ['users' => $users, 'vacancies' => $vacancies, 'seekers' => $seekers]);
        }
 
        return View::make('search', ['users' => $users, 'vacancies' => $vacancies]);
        
        
    }
    
    
}