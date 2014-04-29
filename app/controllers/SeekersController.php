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
                    "phone" => "min:3|max:20"
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
                        Session::flash('message-success','Job Seek has been saved');
                        return Redirect::to("/viewSeeker/{$seeker->id}");
                    }else{
                        Session::flash('message-fail','Could not save job seek');
                        return Redirect::route("seekers/add");
                    }
                }
            
            $data["errors"] = $validator->errors();
            
            $data["intro"] = Input::get("text");
            $data["text"] = Input::get("text");
            $data["phone"] = Input::get("phone");
                        
            Session::flash('message-fail','Neizdevās pievienot darba meklējumu');
            return Redirect::route("seekers/add")->withInput($data)->with($data);
        }
        
        return View::make("seekers/add");
       
    }else{
        Session::flash('message-fail','No Access to action or already added Your jobseek data');
        return Redirect::route("users/profile");
        }    
    }
    
    public function viewAction($id)
    {
        if(Seeker::find($id)){
            $seeker = Seeker::find($id);
            
            $creator = User::where('id',$seeker->user_id)->first();
            $seeker->creatorName = $creator->username;
  
            return View::make("seekers/view", array('seeker'=> $seeker));
        }else{
            Session::flash('message-fail','No job seek with such ID');
            return Redirect::route("home");
        }
    }
    
    public function getCVAction($id)
    {
        if(Seeker::find($id)){
            $seeker = Seeker::find($id);
            
            Return Response::download($seeker->cv);
        }else{
            Session::flash('message-fail','Could not download CV');
            return Redirect::route("home");
        }
    }
    
    public function viewAllAction()
    {
        $seekersCount = Seeker::all();
        if($seekersCount->count()){ //ja ir vismaz viens seeker
            $seekers = Seeker::paginate(10); //all seekers + paginate

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
            $seeker = Seeker::where('user_id',Auth::user()->id)->first();
            
            return View::make("seekers/viewMy", array('seeker'=> $seeker));
        }
        
        //līdz šejienei nekad netiek
        Session::flash('message-fail','Not authorized to do this');
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
                    "phone" => "min:3|max:20"
                ]);
                if ($validator->passes())
                {   
                    $seeker = Seeker::find($id);
                    $seeker->intro = Input::get('intro');
                    $seeker->text = Input::get('text');
                    $seeker->phone = Input::get('phone');
                                  
                        if(Input::hasfile('cv'))
                        {
                            
                            $file = Input::file('cv');
                            $fileName = User::find($seeker->user_id)->username.'__CV__'.str_random(30).time();
                            //$publicPath = public_path('uploads/jobSeekerCVs/');
                                                              
                            $file->move('uploads/jobSeekerCVs',$fileName.'.'.$file->getClientOriginalExtension());      
                            $seeker->cv = 'uploads/jobSeekerCVs/'.$fileName.'.'.$file->getClientOriginalExtension();
                        }                    
                    
                    if($seeker->save())
                    {
                    
                        if($seeker->creator_id==Auth::user()->id){ //ja editoja sevi
                            Session::flash('message-success','Edited Your Job Seek data successfully');
                            return Redirect::route("seekers/viewMy");
                        }else{  //ja admins editoja kādu citu
                            Session::flash('message-success','Edited Job seek data for: "'.$seeker->intro.'"  successfully');
                            return Redirect::to("/viewSeeker/{$id}");
                        }
                    }
                
                }
            
                $data["errors"] = $validator->errors();
                $data["id"] = $seekerId->id;
                $data["intro"] = Input::get("intro");
                $data["text"] = Input::get("text");
                $data["phone"] = Input::get("phone");
                Session::flash('message-fail','Editing Job Seek was not successfull');
                return Redirect::to("/editJobSeek/{$id}")->withInput($data)->with($data);
            }
        
            if(Seeker::find($id)){
                $seeker = Seeker::find($id);
                $data["id"] = $seeker->id;
                $data["intro"] = $seeker->intro;
                $data["text"] = $seeker->text;
                $data["phone"] = $seeker->phone;
                return View::make("/seekers/edit")->with($data);
            }else{
                Session::flash('message-fail','No Seeker with such ID');
                return Redirect::route("seekers/viewAllSeekers");
            }
    
  
        }else{
            Session::flash('message-fail','No Access to action');
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
                            Session::flash('message-success','Job Seek data for: "'.$seeker->intro.'" deleted succesfully');
                            return Redirect::route("seekers/viewAllSeekers");                                
                        }else{
                            //varbūt pielikt else?
                            Session::flash('message-fail','something went wrong, could not delete job seek');
                            return Redirect::route("seekers/viewAllSeekers");  
                        }
                    }
                }
                
                $seeker = Seeker::find($id);
                $data["id"] = $seeker->id;
                $data["intro"] = $seeker->intro;  
                $data["errors"] = $validator->errors();
                Session::flash('message-fail','Could not delete job seek');
                return Redirect::to("/deleteJobSeek/{$id}")->with($data);
                
            }
        
            if(Seeker::find($id)){
                $seeker = Seeker::find($id);
                $data["id"] = $seeker->id;
                $data["intro"] = $seeker->intro;   
                return View::make("seekers/delete")->with($data); 
            }else{
                Session::flash('message-fail','No job seek with such ID');
                return Redirect::route("seekers/viewAllSeekers");
            }  
            
        }else{
            Session::flash('message-fail','No Access to action');
            return Redirect::route("home");
        }
    }    
    
    
    
}