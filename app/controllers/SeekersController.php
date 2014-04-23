<?php

use Illuminate\Support\MessageBag;

class SeekersController extends BaseController {
        
    public function AddAction()
    {
        //if admin or adding own job seek
    if((Auth::check() && Auth::user()->userGroup==3 && !Seeker::where('user_id',Auth::user()->id)->first()) || Auth::user()->userGroup==1)
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
                        return Redirect::to("/");
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
}