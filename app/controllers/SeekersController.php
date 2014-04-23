<?php

use Illuminate\Support\MessageBag;
use Illuminate\Routing\Redirector;

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
                    "cv" => "required|max:3000|mimes:pdf,doc,docx,odt"
                ]);
            
                if ($validator->passes())
                {
                
                    $seeker = new Seeker;
                    $seeker->intro = Input::get('intro');
                    $seeker->text = Input::get('text');
                    $seeker->user_id = Auth::user()->id;
                    
                    $file = Input::file('cv');
                    $fileName = str_random(30).time();
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
                        
            Session::flash('message-fail','Neizdevās pievienot darba meklējumu');
            return Redirect::route("seekers/add")->withInput($data)->with($data);
        }
        
        return View::make("seekers/add");
       
    }else{
        Session::flash('message-fail','No Access to action or already added a jobseek');
        return Redirect::route("home");
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
    
    
    
}