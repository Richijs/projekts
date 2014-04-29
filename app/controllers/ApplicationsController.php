<?php

//use Illuminate\Support\MessageBag;

class ApplicationsController extends BaseController {
    
    public function applyAction($vacancieId)
    {
        //ja neeksistē vakance
        if(!Vacancie::where('id',$vacancieId)->first())
        {
            Session::flash('message-fail','Non existent vacancie');
            return Redirect::route("home");
        }
        
        //ja ir pareiza user grupa
        if((Auth::check() && Auth::user()->userGroup==3) || (Auth::check() && Auth::user()->userGroup==1))
        {        
            //ja nav jau pieteicies šai vakancei
            if (!Application::where('user_id',Auth::user()->id)->where('vacancie_id',$vacancieId)->first())
            {
                //ja nav norādījis savus job seeker datus
                if(!Seeker::where('user_id',Auth::user()->id)->first())
                {
                    Session::flash('message-fail','Sākumā jānorāda darba meklētāja dati');
                    return Redirect::route("seekers/add");
                }
                
                
                $vacancie = Vacancie::find($vacancieId);
                //tad viss ok
                if (Input::server("REQUEST_METHOD") == "POST")
                {
                    $validator = Validator::make(Input::all(), [
                        "letter" => "required|min:10|max:1000",
                    ]);
                    
                if ($validator->passes())
                {   
                    $application = new Application;
                    $application->letter = Input::get('letter');                  
                    $application->user_id = Auth::user()->id;
                    $application->vacancie_id = $vacancieId;
                            
                    if($application->save())
                    {
                            Session::flash('message-success','applied job successfully');
                            return Redirect::to("/viewVacancie/{$vacancieId}");
                    }
                    //varbūt else?
                
                }
            
                $data["errors"] = $validator->errors();
                /*$data["vacancieId"] = $vacancieId;
                $data["vacancieName"] = $vacancie->name;*/
                //$data["letter"] = Input::get("letter");
                Session::flash('message-fail','applying job failed');
                return Redirect::to("/apply/{$vacancieId}")->withInput(Input::all())->with($data);
                }
        

                $data["vacancieId"] = $vacancieId;
                $data["vacancieName"] = $vacancie->name;
                return View::make("/applications/apply")->with($data);
                

        
            }else{
            Session::flash('message-fail','Already applied this job');
            return Redirect::to("/viewVacancie/{$vacancieId}");
            } 
        
        }else{
        Session::flash('message-fail','No Access to action');
        return Redirect::route("home");
        }    
        
    }
    
    public function viewMyAction()
    {
        //if admin or seeker
        if(Auth::check() && (Auth::user()->userGroup==1 || Auth::user()->userGroup==3))
        {
            $applicationCount = Application::where('user_id',Auth::user()->id)->count();
            $applications = Application::where('user_id',Auth::user()->id)->paginate(10);
            $applications->count = $applicationCount;          
            
            foreach ($applications as $application)
            {
                //dabuj konkrēto vakanci katram application
                $vacancie = Vacancie::where('id',$application->vacancie_id)->first();
                $application->vacancieId = $vacancie->id;
                $application->vacancieName = $vacancie->name;
                
            }
                        
            return View::make("applications/viewMy", array('applications'=> $applications));
        }
        
        //līdz šejienei nekad netiek
        Session::flash('message-fail','Not authorized to do this');
        return Redirect::route("home");
        
        
    }
    
    public function viewAction($applicationId)
    {
        if(Application::find($applicationId)){
            
            $application = Application::find($applicationId);
            $vacancie = Vacancie::where('id',$application->vacancie_id)->first();
            
            //Var apskatīt ADMINS,PATS un KONKRĒTĀ DARBA DEVĒJS
            if(Auth::user()->userGroup==1 //admins
                || $application->user_id == Auth::user()->id //sava aplikācija    
                || $vacancie->creator_id == Auth::user()->id //vakances darba devējs
            ){
  
            
                $seeker = Seeker::where('user_id',$application->user_id)->first();
            //vajag arī padot user
                
                return View::make("applications/view", array('application'=> $application,'vacancie'=>$vacancie,'seeker'=>$seeker));
        
            
            }else{
                Session::flash('message-fail','Not authorized to do this');
                return Redirect::route("home");
            }
 
        }else{
            Session::flash('message-fail','No application with such ID');
            return Redirect::route("home");
        }
       
        
    }
    
    
    public function viewApplicantsAction($vacancieId)
    {
        if(Auth::user()->userGroup==1 || Vacancie::where('id',$vacancieId)->where('creator_id',Auth::user()->id)->first()){
            if(!Vacancie::find($vacancieId)){
                Session::flash('message-fail','No application with such ID');
                return Redirect::route("vacancies/myVacancies");
            }
        
                $applicantCount = Application::where('vacancie_id',$vacancieId)->count();
                $applications = Application::where('vacancie_id',$vacancieId)->paginate(10);
                
                $applications->count = $applicantCount;
                $applications->vacancie = Vacancie::find($vacancieId);
                foreach ($applications as $application){
                    
                    $user = User::find($application->user_id);
                    $application->user = $user;
                    
                }
            
            return View::make("applications/viewApplicants", array('applications'=> $applications));
        
         
         }else{
                Session::flash('message-fail','Not authorized to do this');
                return Redirect::route("home");
            }
    }
    
    public function deleteAction($applicationId)
    {
        //if admin or deleting own application
        if(Auth::check() && (Application::where('id',$applicationId)->where('user_id',Auth::user()->id)->first() || Auth::user()->userGroup==1))
        {

            if (Input::server("REQUEST_METHOD") == "POST")
            {
                $validator = Validator::make(Input::all(), [
                    "checkbox" => "required"
                ]);
                
                if ($validator->passes())
                {
                    $application = Application::find($applicationId);
                    
                    $checkbox = Input::get('checkbox');
                    
                    if($checkbox)
                    {                            
                        if($application->delete())
                        {
                            Session::flash('message-success','Application with Id: "'.$application->id.'" deleted succesfully');
                            return Redirect::route("applications/viewMy");                                
                        }else{
                            //varbūt pielikt else?
                            Session::flash('message-fail','something went wrong, could not delete application');
                            return Redirect::route("home");  
                        }
                    }
                }
                
                /*$application = Application::find($applicationId);
                $vacancie = Vacancie::find($application->vacancie_id);
                
                $data["applicationId"] = $applicationId;
                $data["applicationLetter"] = $application->letter;
                $data["vacancieId"] = $vacancie->id;
                $data["vacancieName"] = $vacancie->name;*/
                $data["errors"] = $validator->errors();
                Session::flash('message-fail','Could not delete application');
                return Redirect::to("/deleteApplication/{$applicationId}")->with($data);
                
            }
        
            if(Application::find($applicationId)){
                $application = Application::find($applicationId);
                $vacancie = Vacancie::find($application->vacancie_id);
                
                $data["applicationId"] = $applicationId;
                $data["applicationLetter"] = $application->letter;
                $data["vacancieId"] = $vacancie->id;
                $data["vacancieName"] = $vacancie->name;
                return View::make("applications/delete")->with($data); 
            }else{
                Session::flash('message-fail','No application with such ID');
                return Redirect::route("home");
            }  
            
        }else{
            Session::flash('message-fail','No Access to action');
            return Redirect::route("home");
        }
    
    }
    
    
    public function editAction($applicationId)
    {
        //if admin or deleting own application
        if(Auth::check() && (Application::where('id',$applicationId)->where('user_id',Auth::user()->id)->first() || Auth::user()->userGroup==1))
        {

                if (Input::server("REQUEST_METHOD") == "POST")
                {
                                       
                    $validator = Validator::make(Input::all(), [
                        "letter" => "required|min:10|max:1000",
                    ]);
                    
                if ($validator->passes())
                {   
                    $application = Application::find($applicationId);
                    $application->letter = Input::get('letter');                  
                            
                    if($application->save())
                    {
                            Session::flash('message-success','edited Application successfully');
                            return Redirect::to("/viewApplication/{$applicationId}");
                    }
                    //varbūt else?
                
                }
            
                //$application = Application::find($applicationId); //varbūt uztaisīt globālāku metodē
                //$user = User::find($application->user_id);
                
                $data["errors"] = $validator->errors();
                /*$data["userId"] = $user->id;
                $data["userName"] = $user->username;
                $data["applicationId"] = $application->id;
                $data["vacancieId"] = $application->vacancie_id;*/
                //$data["letter"] = Input::get("letter");
                Session::flash('message-fail','Editing Application was not successfull');
                return Redirect::to("/editApplication/{$applicationId}")->withInput(Input::all())->with($data);
                }
        
            if(Application::find($applicationId)){
                $application = Application::find($applicationId);
                $user = User::find($application->user_id);
                
                $data["userId"] = $user->id;
                $data["userName"] = $user->username;
                $data["applicationId"] = $application->id;
                $data["vacancieId"] = $application->vacancie_id;
                $data["letter"] = $application->letter;
                return View::make("/applications/edit")->with($data);
            }else{
                Session::flash('message-fail','No application with such ID');
                return Redirect::route("home");
            }
    
  
        }else{
            Session::flash('message-fail','No Access to action');
            return Redirect::route("home");
        }    
        
    }
    
    
    
}