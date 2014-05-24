<?php

class ApplicationsController extends BaseController {
    
    //pieteikuma izveide konkrētai vakancei
    public function applyAction($vacancieId)
    {
            //ja neeksistē vakance, kurai tiek mēģināts pieteikties
        if(!Vacancie::where('id',$vacancieId)->first())
        {
            Session::flash('message-fail',trans('messages.non-existent-vacancie'));
            return Redirect::route("home");
        }
        
            //ja ir pareiza lietotāja grupa
        if(Auth::check() && (Auth::user()->userGroup==3 || Auth::user()->userGroup==1))
        {        
                //ja tiek mēģināts pieteikties savai vanakcei (administratora gadījumā)
            if(Vacancie::where('creator_id',Auth::user()->id)->where('id',$vacancieId)->first()){
                Session::flash('message-fail',trans('messages.cant-apply-own-vacancie'));
                return Redirect::route("vacancies/viewAllVacancies");
            }
            
                //ja nav jau pieteicies šai vakancei
            if (!Application::where('user_id',Auth::user()->id)->where('vacancie_id',$vacancieId)->first())
            {
                    //ja nav norādījis savus darba meklētāja datus
                if(!Seeker::where('user_id',Auth::user()->id)->first())
                {
                    Session::flash('message-fail',trans('messages.before-applying-vacancie'));
                    
                        //lai pēctam lietotāju būtu iespējams pārvirzīt tieši uz šīs vakances pieteikumu
                    Session::put('vacancieId',$vacancieId); 
                    return Redirect::route("seekers/add");
                }
                
                    //eksistējošā vakance
                $vacancie = Vacancie::find($vacancieId);
                
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
                         
                            //pieteikums tiek saglabāts
                        if($application->save())
                        {
                            Session::flash('message-success',trans('messages.applied-vacancie-successfully'));
                            return Redirect::to("/viewVacancie/{$vacancieId}");
                        }
                    }
            
                    //pieteikuma kļūmju gadījumā
                $data["errors"] = $validator->errors();
                Session::flash('message-fail',trans('messages.applying-vacancie-failed'));
                return Redirect::to("/apply/{$vacancieId}")->withInput(Input::all())->with($data);
                }
                
                    //dati izvadei
                $data["vacancieId"] = $vacancieId;
                $data["vacancieName"] = $vacancie->name;
                return View::make("/applications/apply")->with($data);

            }else{
                //lietotājs jau ir pieteicies šai vakancei
            Session::flash('message-fail',trans('messages.already-applied-vacancie'));
            return Redirect::to("/viewVacancie/{$vacancieId}");
            } 
        
        }else{
            //lietotājam nav attiecīgā pieeja pieteikties vakancēm
        Session::flash('message-fail',trans('messages.no-access'));
        return Redirect::route("home");
        }    
        
    }
    
    //savu pieteikumu apskatīšana
    public function viewMyAction()
    {
            //savu pieteikumu apskatīšana paredzēta vienīgi administratoriem/darba meklētājiem
        if(Auth::check() && (Auth::user()->userGroup==1 || Auth::user()->userGroup==3))
        {
            $applicationCount = Application::where('user_id',Auth::user()->id)->count();
            $applications = Application::where('user_id',Auth::user()->id)->orderBy('created_at','DESC')->paginate(20);
            $applications->count = $applicationCount;          
            
            foreach ($applications as $application)
            {
                    //iegūst konkrēto vakanci katram pieteikumam
                $vacancie = Vacancie::where('id',$application->vacancie_id)->first();
                $application->vacancieId = $vacancie->id;
                $application->vacancieName = $vacancie->name;  
            }
                        
            return View::make("applications/viewMy", array('applications'=> $applications));
        }
        
            //neatļautas pieejas gadījumā (normālā gadījumā tik tālu nebūtu jānokļūst)
        Session::flash('message-fail',trans('messages.not-authorized'));
        return Redirect::route("home");
        
        
    }
    
    //pieteikuma apskatīšana
    public function viewAction($applicationId)
    {
            //ja pieteikums tiek atrasts sistēmā
        if(Application::find($applicationId)){
            
            $application = Application::find($applicationId);
            $vacancie = Vacancie::where('id',$application->vacancie_id)->first();
            
                //Konkrētu pieteikumu atļauts apskatīt pašam,administratoram un konkrētās vakances darba devējam
            if(Auth::user()->userGroup==1 //administrators
            || $application->user_id == Auth::user()->id //savs pieteikums   
            || $vacancie->creator_id == Auth::user()->id) //vakances darba devējs
            {

                $seeker = Seeker::where('user_id',$application->user_id)->first();
                $user = User::find($seeker->user_id);
                
                    //apzīmē pieteikumu kā "skatītu"
                    if($vacancie->creator_id == Auth::user()->id && $application->viewed != 1){
                        $app = Application::find($application->id);
                        $app->viewed = 1;
                        $app->save();
                    }
                
                    //skatam nepieciešams padot diezgan daudz informāciju par vakanci/darba meklētāju..
                return View::make("applications/view", array('application'=> $application,'vacancie'=>$vacancie,'seeker'=>$seeker,'user'=>$user));
        
            }else{
                    //neatļautas autorizācijas gadījumā
                Session::flash('message-fail',trans('messages.not-authorized'));
                return Redirect::route("home");
            }
 
        }else{
                //ja aplikācija neeksistē
            Session::flash('message-fail',trans('messages.non-existent-application'));
            return Redirect::route("home");
        }
    }
    
    //konkrētas vakances pieteikušos lietotāju pieteikumu apskatīšana
    public function viewApplicantsAction($vacancieId)
    {
            //visu vakances pieteikumu apskatīšana paredzēta vienīgi administratoriem/vakances autoram
        if(Auth::user()->userGroup==1 || Vacancie::where('id',$vacancieId)->where('creator_id',Auth::user()->id)->first()){
            
            if(!Vacancie::find($vacancieId)){
                    //neeksistējošas vakances gadījumā
                Session::flash('message-fail',trans('messages.non-existent-application'));
                return Redirect::route("vacancies/myVacancies");
            }
        
                $applicantCount = Application::where('vacancie_id',$vacancieId)->count();
                $applications = Application::where('vacancie_id',$vacancieId)->orderBy('created_at','DESC')->paginate(20);
                
                $applications->count = $applicantCount;
                $applications->vacancie = Vacancie::find($vacancieId);
                foreach ($applications as $application){
                    
                    $user = User::find($application->user_id);
                    $application->user = $user;
                    
                        //lai varētu atzīmēt pieteikumus kā jaunus, jeb nelasītus
                    if(Vacancie::where('id',$vacancieId)->where('creator_id',Auth::user()->id)->first() && $application->viewed != 1){
                        $application->new = true;
                    }
                }
            
            return View::make("applications/viewApplicants", array('applications'=> $applications));
        
         
         }else{
                    //neatļautas pieejas gadījumā
                Session::flash('message-fail',trans('messages.not-authorized'));
                return Redirect::route("home");
            }
    }
    
    //pieteikuma dzēšana
    public function deleteAction($applicationId)
    {
            //pieeja vienīgi administratoram un/vai pieteikuma izveidotājam
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
                            Session::flash('message-success',trans('messages.application-deleted-successfully',['id' => $application->id]));
                            return Redirect::route("applications/viewMy");                                
                        }else{
                                //ja kāda nezināma iemesla dēļ netiek izdzēsts pieteikums
                            Session::flash('message-fail',trans('messages.wrong-couldnt-delete-application'));
                            return Redirect::route("home");  
                        }
                    }
                }
                    
                    //gadījumā, ja netika atķeksēts dzēšanas apstiprinājums
                $data["errors"] = $validator->errors();
                Session::flash('message-fail',trans('messages.couldnt-delete-application'));
                return Redirect::to("/deleteApplication/{$applicationId}")->with($data);  
            }
        
            if(Application::find($applicationId)){
                $application = Application::find($applicationId);
                $vacancie = Vacancie::find($application->vacancie_id);
                
                    //datu izvadei
                $data["applicationId"] = $applicationId;
                $data["applicationLetter"] = $application->letter;
                $data["vacancieId"] = $vacancie->id;
                $data["vacancieName"] = $vacancie->name;
                return View::make("applications/delete")->with($data); 
            }else{
                    //gadījumā, kad tiek mēģināts dzēst neeksistējošu pieteikumu
                Session::flash('message-fail',trans('messages.non-existent-application'));
                return Redirect::route("home");
            }  
            
        }else{
                //kad lietotājam nav tiesības dzēst konkrēto pieteikumu
            Session::flash('message-fail',trans('messages.no-access'));
            return Redirect::route("home");
        }
    }
    
    //pieteikuma rediģēšana
    public function editAction($applicationId)
    {
            //pieeja vienīgi administratoram vai paša pieteikuma autoram
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
                            Session::flash('message-success',trans('messages.edited-application-successfully'));
                            return Redirect::to("/viewApplication/{$applicationId}");
                    }
                }
            
                    //neveiksmīga pieteikuma rediģēšanas gadījumā
                $data["errors"] = $validator->errors();
                Session::flash('message-fail',trans('messages.editing-application-failed'));
                return Redirect::to("/editApplication/{$applicationId}")->withInput(Input::all())->with($data);
            }
        
            if(Application::find($applicationId)){
                $application = Application::find($applicationId);
                $user = User::find($application->user_id);
                
                    //datu izvadei
                $data["userId"] = $user->id;
                $data["userName"] = $user->username;
                $data["applicationId"] = $application->id;
                $data["vacancieId"] = $application->vacancie_id;
                $data["letter"] = $application->letter;
                return View::make("/applications/edit")->with($data);
            }else{
                    //gadījumā, ja neeksistē konkrētais pieteikums
                Session::flash('message-fail',trans('messages.non-existent-application'));
                return Redirect::route("home");
            }
    
        }else{
                //ja lietotājam nav pieeja rediģēt pieteikumu
            Session::flash('message-fail',trans('messages.no-access'));
            return Redirect::route("home");
        }    
    }

    
}