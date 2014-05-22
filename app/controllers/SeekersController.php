<?php

//use Illuminate\Support\MessageBag;
use Illuminate\Routing\Redirector;

class SeekersController extends BaseController {
        
    //darba meklētāja datu pievienošana
    public function AddAction()
    {
            //atļauts vienīgi administratoriem un darba meklētājiem
            //uz vienu lietotāju tikai un vienīgi viens darba meklējums
        if((Auth::check() && Auth::user()->userGroup==3 && !Seeker::where('user_id',Auth::user()->id)->first()) || (Auth::user()->userGroup==1 && !Seeker::where('user_id',Auth::user()->id)->first()))
        {
            if (Input::server("REQUEST_METHOD") == "POST")
            {
                $validator = Validator::make(Input::all(), [
                    "intro" => "required|min:3|max:100",
                    "text" => "required|min:10|max:1000",
                    "cv" => "required|max:3000|mimes:pdf,doc,docx,odt",
                    "phone" => "numeric|digits_between:3,20"
                ]);
            
                if ($validator->passes())
                {
                
                    $seeker = new Seeker;
                    $seeker->intro = Input::get('intro');
                    $seeker->text = Input::get('text');
                    $seeker->phone = Input::get('phone');
                    $seeker->user_id = Auth::user()->id;
                    
                    $file = Input::file('cv');
                    $fileName = Auth::user()->username.'__CV__'.str_random(30).time();
                                                              
                    $file->move('uploads/jobSeekerCVs',$fileName.'.'.$file->getClientOriginalExtension());      
                    $seeker->cv = 'uploads/jobSeekerCVs/'.$fileName.'.'.$file->getClientOriginalExtension();    
                    
                    if($seeker->save())
                    {   
                        //ja lietotājs ir ticis pārvirzīts no vakances pieteikuma
                        if(Session::has('vacancieId'))
                        {
                            $redirectToVacancie = Session::get('vacancieId');
                            Session::forget('vacancieId');
                            Session::flash('message-success',trans('messages.jobseek-saved-now-apply'));                           
                            return Redirect::to("/apply/{$redirectToVacancie}");
                        }    
                            
                            
                        Session::flash('message-success',trans('messages.jobseek-saved'));
                        return Redirect::route("seekers/viewMy");
                    }else{
                            //ja darba meklētāja dati netika saglabāti
                        Session::flash('message-fail',trans('messages.jobseek-not-saved'));
                        return Redirect::route("seekers/add");
                    }
                }
            
                $data["errors"] = $validator->errors();
                Session::flash('message-fail',trans('messages.jobseek-not-added'));
                return Redirect::route("seekers/add")->withInput(Input::except('cv'))->with($data);
            }
        
            return View::make("seekers/add");
       
        }else{
                //ja jau tika pievienoti darba meklētāja dati
            if(Auth::check() && Seeker::where('user_id',Auth::user()->id)->first()){
                Session::flash('message-info',trans('messages.already-added-jobseek'));
                return Redirect::route("seekers/viewMy");
            }else{
                    //ja nav pieeja pievienot darba meklētāja datus
                Session::flash('message-fail',trans('messages.no-access'));
                return Redirect::route("users/profile");
            }
        }    
    }
    
    //konkrēta darba meklētāja datu apskatīšana
    public function viewAction($id)
    {       
            //ja atrod šādu lietotāju
        if(Seeker::find($id)){
                
            //pieeja administratoram/darba devējam un pašam darba meklētājam
            if(Auth::user()->userGroup==1 || Auth::user()->userGroup==2 || Seeker::find($id)->user_id == Auth::user()->id)
            {
                $seeker = Seeker::find($id);
            
                $creator = User::where('id',$seeker->user_id)->first();
                $seeker->creatorName = $creator->username;
  
                return View::make("seekers/view", array('seeker'=> $seeker));
                
            }else{ //ja nav pieejas skatīt
                Session::flash('message-fail',trans('messages.not-authorized'));
                return Redirect::route("home");
            }        
                
        }else{
                //ja lietotājs netika atrasts
            Session::flash('message-fail',trans('messages.non-existent-jobseek'));
            return Redirect::route("home");
        }   
    }
    
    //CV lejupielāde
    public function getCVAction($id)
    {   
            //ja eksistē šādi darba meklētāja dati
        if(Seeker::find($id)){
            
                //pieejams vienīgi administratoriem/darba devējiem un pašam pievienotājam
            if(Auth::user()->userGroup==1 || Auth::user()->userGroup==2 || Seeker::find($id)->user_id == Auth::user()->id)
            {
                $seeker = Seeker::find($id);
                
                    //ja šāds fails eksistē
                if(file_exists($seeker->cv)){
                    Return Response::download($seeker->cv);
                }else{ 
                        //neeksistējoša faila gadījumā
                    Session::flash('message-fail',trans('messages.couldnt-download-cv'));
                    return Redirect::back();
                }
            
            }else{ //ja pieeja nav atļauta
                Session::flash('message-fail',trans('messages.not-authorized'));
                return Redirect::route("home");
            }   
                
        }else{ //ja neeksistē šādi darba meklētāja dati
            Session::flash('message-fail',trans('messages.couldnt-download-cv'));
            return Redirect::route("home");
        }
    }
    
    //visu darba meklētāju datu apskate
    public function viewAllAction()
    {
        $seekersCount = Seeker::all();
        if($seekersCount->count()){ //ja sistēmā ir vismaz viens darba meklētāja datu ieraksts
            $seekers = Seeker::orderBy('created_at','DESC')->paginate(10); //visi darba meklētāju ieraksti + "paginate"

                //lai noskaidrotu katra darba meklētāja lietotājvārdu
            foreach($seekers as $seeker){
                $creator = User::where('id',$seeker->user_id)->first();
                $seeker->creatorName = $creator->username;
            }
            
            return View::make("seekers/viewAllSeekers", array('seekers'=> $seekers));
        }else{
                //gadījumā, ja sistēmā nav neviena darba meklētāja datu ieraksta
            return View::make("seekers/ViewAllSeekers");
        }
    }
    
    //sava darba meklējuma datu apskate
    public function viewMyAction()
    {
            //ja administrators vai darba meklētājs
        if(Auth::check() && (Auth::user()->userGroup==1 || Auth::user()->userGroup==3))
        {
                //ja arī neeksistē darba meklētāja dati, ar to tiks galā skats
            $seeker = Seeker::where('user_id',Auth::user()->id)->first();
            
            return View::make("seekers/viewMy", array('seeker'=> $seeker));
        }
        
            //neatļautas pieejas gadījumā
        Session::flash('message-fail',trans('messages.not-authorized'));
        return Redirect::route("home");
    }
    
    //darba meklētāja datu rediģēšana
    public function editAction($id)
    {
            //pieejams administratoriem un pašam darba meklējuma datu pievienotājam
        if((Auth::check() && Auth::user()->userGroup==3 && Seeker::where('id',$id)->where('user_id',Auth::user()->id)->first()) || Auth::user()->userGroup==1)
        {
            if (Input::server("REQUEST_METHOD") == "POST")
            {
                $seekerId = Seeker::where('id',$id)->first();
            
                $validator = Validator::make(Input::all(), [
                    "intro" => "required|min:3|max:100",
                    "text" => "required|min:10|max:1000",
                    "cv" => "max:3000|mimes:pdf,doc,docx,odt", //vairs nav obligāts lauks, jo var būt situācija, kad lietotājs nevēlas mainīt CV
                    "phone" => "numeric|digits_between:3,20"
                ]);
                if ($validator->passes())
                {   
                    $seeker = Seeker::find($id);
                    $seeker->intro = Input::get('intro');
                    $seeker->text = Input::get('text');
                    $seeker->phone = Input::get('phone');
                                  
                        if(Input::hasfile('cv'))
                        {
                                //iepriekšējā CV lokācija
                            if($seeker->cv){
                               $oldCV = $seeker->cv;  
                            }
                            
                            $file = Input::file('cv');
                            $fileName = User::find($seeker->user_id)->username.'__CV__'.str_random(30).time();
                                                              
                            $file->move('uploads/jobSeekerCVs',$fileName.'.'.$file->getClientOriginalExtension());      
                            $seeker->cv = 'uploads/jobSeekerCVs/'.$fileName.'.'.$file->getClientOriginalExtension();
                        }                    
                    
                    if($seeker->save())
                    {
                        //ja tika augšupielādēts jauns CV, dzēš veco no failu sistēmas
                        if(isset($oldCV)){
                            File::delete(public_path().'\\'.$oldCV);
                        }
                            
                            //ja lietotājs rediģēja savus datus
                        if($seeker->creator_id==Auth::user()->id){
                            Session::flash('message-success',trans('messages.edited-your-job-seek'));
                            return Redirect::route("seekers/viewMy");
                        }else{  //ja administrators rediģēja kāda cita lietotāja datus
                            Session::flash('message-success',trans('messages.edited-job-seek',['seek' => $seeker->intro]));
                            return Redirect::to("/viewSeeker/{$id}");
                        }
                    }
                }
            
                $data["errors"] = $validator->errors();
                Session::flash('message-fail',trans('messages.couldnt-edit-job-seek'));
                return Redirect::to("/editJobSeek/{$id}")->withInput(Input::except('cv'))->with($data);
            }
                
                //ja atrada meklētos darba meklētāja datus
            if(Seeker::find($id)){
                $seeker = Seeker::find($id);
                
                    //datu izvadei
                $data["id"] = $seeker->id;
                $data["intro"] = $seeker->intro;
                $data["text"] = $seeker->text;
                $data["phone"] = $seeker->phone;
                return View::make("/seekers/edit")->with($data);
            }else{ //pretējā gadījumā
                Session::flash('message-fail',trans('messages.non-existent-jobseek'));
                
                if(Auth::user()->userGroup==1){
                    return Redirect::route("seekers/viewAllSeekers");
                }else{
                    return Redirect::route("users/profile");
                }
            }
    
        }else{ //ja lietotājam nav pieeja šai funkcijai
            Session::flash('message-fail',trans('messages.no-access'));
            return Redirect::route("home");
        }    
        
    }
    
    //džēš darba meklētāja datus
    public function deleteAction($id)
    {
            //pieejams administratoriem un pašam darba meklējuma datu pievienotājam
        if((Auth::check() && Auth::user()->userGroup==3 && Seeker::where('id',$id)->where('user_id',Auth::user()->id)->first()) || Auth::user()->userGroup==1)
        {
            if (Input::server("REQUEST_METHOD") == "POST")
            {
                $validator = Validator::make(Input::all(), [
                    "checkbox" => "required"
                ]);
                
                if ($validator->passes())
                {
                    $seeker = Seeker::find($id);
                    
                    $checkbox = Input::get('checkbox');
                    
                    if($checkbox)
                    {                           
                            //ja darba meklētāja datu dzēšana ir veiksmīga
                        if($seeker->delete())
                        {
                            //dzēš CV no failu sistēmas
                            if(isset($seeker->cv)){
                                File::delete(public_path().'\\'.$seeker->cv);
                            }
                            
                            Session::flash('message-success',trans('messages.deleted-job-seek',['seek' => $seeker->intro]));
                            if(Auth::user()->userGroup==1){
                                return Redirect::route("seekers/viewAllSeekers");
                            }else{
                                return Redirect::route("users/profile");
                            }
                        }else{
                                //ja darba meklētāja datu dzēšana bija neveiksmīga
                            Session::flash('message-fail',trans('messages.wrong-couldnt-delete-job-seek'));
                            return Redirect::route("home");  
                        }
                    }
                }
                
                $data["errors"] = $validator->errors();
                Session::flash('message-fail',trans('messages.couldnt-delete-job-seek'));
                return Redirect::to("/deleteJobSeek/{$id}")->with($data);
            }
        
            if(Seeker::find($id)){
                $seeker = Seeker::find($id);
                
                    //datu izvadei
                $data["id"] = $seeker->id;
                $data["intro"] = $seeker->intro;   
                return View::make("seekers/delete")->with($data); 
            }else{
                Session::flash('message-fail',trans('messages.non-existent-jobseek'));
                if(Auth::user()->userGroup==1){
                    return Redirect::route("seekers/viewAllSeekers");
                }else{
                    return Redirect::route("users/profile");
                }
            }  
            
        }else{ //ja lietotājam nav pieeja šai funkcijai
            Session::flash('message-fail',trans('messages.no-access'));
            return Redirect::route("home");
        }
    }    
    
    
    
}