<?php

//use Illuminate\Support\MessageBag;
//use Illuminate\Routing\Redirector;

class SeekersController extends BaseController {
        
    public function AddAction()
    {
        //admin can also add only one job seek
        if((Auth::check() && Auth::user()->userGroup==3 && !Seeker::where('user_id',Auth::user()->id)->first()) || (Auth::user()->userGroup==1 && !Seeker::where('user_id',Auth::user()->id)->first()))
        {
        
            if (Input::server("REQUEST_METHOD") == "POST")
            {
                $validator = Validator::make(Input::all(), [
                    "intro" => "required|min:3|max:100",
                    "text" => "required|min:10|max:500",
                    "cv" => "required|max:3000|mimes:pdf,doc,docx,odt",
                    "phone" => "required|numeric|digits_between:3,20"
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
                    //$publicPath = public_path('uploads/jobSeekerCVs/');
                                                              
                    $file->move('uploads/jobSeekerCVs',$fileName.'.'.$file->getClientOriginalExtension());      
                    $seeker->cv = 'uploads/jobSeekerCVs/'.$fileName.'.'.$file->getClientOriginalExtension();    
                    
                    if($seeker->save())
                    {
                        if(Session::has('vacancieId')) //ja ir nācis no "apply vacancie, bet redirektēts uz seeker data"
                        {
                            $redirectToVacancie = Session::get('vacancieId');
                            Session::forget('vacancieId');
                            Session::flash('message-success',trans('messages.jobseek-saved-now-apply'));                           
                            return Redirect::to("/apply/{$redirectToVacancie}");
                        }    
                            
                            
                        Session::flash('message-success',trans('messages.jobseek-saved'));
                        return Redirect::to("/viewSeeker/{$seeker->id}");
                    }else{
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
        
            if(Auth::check() && Seeker::where('user_id',Auth::user()->id)->first()){
                Session::flash('message-info',trans('messages.already-added-jobseek'));
                return Redirect::route("seekers/viewMy");
            }else{
                Session::flash('message-fail',trans('messages.no-access'));
                return Redirect::route("users/profile");
            }
        
        }    
    }
    
    public function viewAction($id)
    {   
        if(Seeker::find($id)){
                
            //admin or own job seek data
            if(Auth::user()->userGroup==1 || Auth::user()->userGroup==2 || Seeker::find($id)->user_id == Auth::user()->id)
            {
                $seeker = Seeker::find($id);
            
                $creator = User::where('id',$seeker->user_id)->first();
                $seeker->creatorName = $creator->username;
  
                return View::make("seekers/view", array('seeker'=> $seeker));
                
            }else{
                Session::flash('message-fail',trans('messages.not-authorized'));
                return Redirect::route("home");
            }        
                
        }else{
            Session::flash('message-fail',trans('messages.non-existent-jobseek'));
            return Redirect::route("home");
        }
            
    }
    
    public function getCVAction($id)
    {
        if(Seeker::find($id)){
            
            //admin or own CV
            if(Auth::user()->userGroup==1 || Auth::user()->userGroup==2 || Seeker::find($id)->user_id == Auth::user()->id)
            {
            
                $seeker = Seeker::find($id);
            
                if(file_exists($seeker->cv)){
                    Return Response::download($seeker->cv);
                }else{
                    Session::flash('message-fail',trans('messages.couldnt-download-cv'));
                    return Redirect::to("/viewSeeker/{$seeker->id}");
                }
            
            }else{
                Session::flash('message-fail',trans('messages.not-authorized'));
                return Redirect::route("home");
            }   
                
        }else{
            Session::flash('message-fail',trans('messages.couldnt-download-cv'));
            return Redirect::route("home"); //redirect back?
        }
    }
    
    public function viewAllAction()
    {
        $seekersCount = Seeker::all();
        if($seekersCount->count()){ //ja ir vismaz viens seeker
            $seekers = Seeker::orderBy('created_at','DESC')->paginate(10); //all seekers + paginate

            foreach($seekers as $seeker){
                
                $creator = User::where('id',$seeker->user_id)->first();
                $seeker->creatorName = $creator->username;
            }
            
            return View::make("seekers/viewAllSeekers", array('seekers'=> $seekers));
        }else{
            return View::make("seekers/ViewAllSeekers");
        }
    }
    
     public function viewMyAction()
    {
        //if admin or seeker
        if(Auth::check() && (Auth::user()->userGroup==1 || Auth::user()->userGroup==3))
        {
            //if not set, the view handles it anyway
            $seeker = Seeker::where('user_id',Auth::user()->id)->first();
            
            return View::make("seekers/viewMy", array('seeker'=> $seeker));
        }
        
        //līdz šejienei nekad netiek
        Session::flash('message-fail',trans('messages.not-authorized'));
        return Redirect::route("home");
    }
    
    //todo fix smth
    public function editAction($id)
    {
        //if admin or editing own job seek
        if((Auth::check() && Auth::user()->userGroup==3 && Seeker::where('id',$id)->where('user_id',Auth::user()->id)->first()) || Auth::user()->userGroup==1)
        {
            if (Input::server("REQUEST_METHOD") == "POST")
            {
                $seekerId = Seeker::where('id',$id)->first();
            
                $validator = Validator::make(Input::all(), [
                    "intro" => "required|min:3|max:100",
                    "text" => "required|min:10|max:500",
                    "cv" => "max:3000|mimes:pdf,doc,docx,odt", //vairs nav required, jo var būt, ka nevēlas mainīt cv
                    "phone" => "required|numeric|digits_between:3,20"
                ]);
                if ($validator->passes())
                {   
                    $seeker = Seeker::find($id);
                    $seeker->intro = Input::get('intro');
                    $seeker->text = Input::get('text');
                    $seeker->phone = Input::get('phone');
                                  
                        if(Input::hasfile('cv'))
                        {
                            //old cv link
                            if($seeker->cv){
                               $oldCV = $seeker->cv;  
                            }
                            
                            $file = Input::file('cv');
                            $fileName = User::find($seeker->user_id)->username.'__CV__'.str_random(30).time();
                            //$publicPath = public_path('uploads/jobSeekerCVs/');
                                                              
                            $file->move('uploads/jobSeekerCVs',$fileName.'.'.$file->getClientOriginalExtension());      
                            $seeker->cv = 'uploads/jobSeekerCVs/'.$fileName.'.'.$file->getClientOriginalExtension();
                        }                    
                    
                    if($seeker->save())
                    {
                        //deletes old cv from filesystem, if new cv was uploaded
                        if(isset($oldCV)){
                            File::delete(public_path().'\\'.$oldCV);
                        }
                    
                        if($seeker->creator_id==Auth::user()->id){ //ja editoja sevi
                            Session::flash('message-success',trans('messages.edited-your-job-seek'));
                            return Redirect::route("seekers/viewMy");
                        }else{  //ja admins editoja kādu citu
                            Session::flash('message-success',trans('messages.edited-job-seek',['seek' => $seeker->intro]));
                            return Redirect::to("/viewSeeker/{$id}");
                        }
                    }
                
                }
            
                $data["errors"] = $validator->errors();
                Session::flash('message-fail',trans('messages.couldnt-edit-job-seek'));
                return Redirect::to("/editJobSeek/{$id}")->withInput(Input::except('cv'))->with($data);
            }
        
            if(Seeker::find($id)){
                $seeker = Seeker::find($id);
                $data["id"] = $seeker->id;
                $data["intro"] = $seeker->intro;
                $data["text"] = $seeker->text;
                $data["phone"] = $seeker->phone;
                return View::make("/seekers/edit")->with($data);
            }else{
                Session::flash('message-fail',trans('messages.non-existent-jobseek'));
                if(Auth::user()->userGroup==1){
                    return Redirect::route("seekers/viewAllSeekers");
                }else{
                    return Redirect::route("users/profile");
                }
            }
    
  
        }else{
            Session::flash('message-fail',trans('messages.no-access'));
            return Redirect::route("home");
        }    
        
    }
    
    
    public function deleteAction($id)
    {
        //if admin or deleting own job seek
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
                        if($seeker->delete())
                        {
                            //deletes cv from filesystem
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
                            //varbūt pielikt else?
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
            
        }else{
            Session::flash('message-fail',trans('messages.no-access'));
            return Redirect::route("home");
        }
    }    
    
    
    
}