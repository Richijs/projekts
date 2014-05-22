<?php

use Intervention\Image\Image;

class VacanciesController extends BaseController {
        
    //visu vakanču apskate
    public function viewAllAction()
    {
        $vacanciesCount = Vacancie::all();
        if($vacanciesCount->count()){ //ja sistēmā ir vismaz viena vakance
            $vacancies = Vacancie::orderBy('created_at','DESC')->paginate(10); //visas vakances + "paginate"

            foreach($vacancies as $vacancie){
                
                $creator = User::where('id',$vacancie->creator_id)->first();
                $vacancie->creatorName = $creator->username;
                
                    //lietotāju rekomendāciju skaits
                $vacancie->userRecommends = Recommendation::where('employer_id',$creator->id)->count();
                    //vakanču pieteikumu skaits
                $vacancie->applied = Application::where('vacancie_id',$vacancie->id)->count();
                
                if(Auth::check()){
                    if(Recommendation::where('user_id',Auth::user()->id)->where('employer_id',$creator->id)->first()){
                        $vacancie->recommended = true; //lai skatā varētu uzzināt rekomendācijas statusu
                    }
                }
            }

            return View::make("vacancies/viewAllVacancies", array('vacancies'=> $vacancies));
        }else{
                //ja sistēmā nav neviena vakance
            return View::make("vacancies/ViewAllVacancies");
        }
    }
    
    //vakances pievienošana
    public function AddAction()
    {
        if (Input::server("REQUEST_METHOD") == "POST")
        {
            $validator = Validator::make(Input::all(), [
                "name" => "required|min:3|max:100|unique:vacancies,name",
                "text" => "required|min:10|max:1000",
                "poster" => "image|max:3000|mimes:jpg,jpeg,png,bmp,gif",
                "phone" => "min:3|max:20",
                "company" => "max:100"
            ]);
            
            if ($validator->passes())
            {                
                    $vacancie = new Vacancie;
                    $vacancie->name = Input::get('name');
                    $vacancie->text = Input::get('text');
                    $vacancie->creator_id = Auth::user()->id;
                    $vacancie->phone = Input::get('phone');
                    $vacancie->company = Input::get('company');
                    
                    if(Input::hasfile('poster'))
                    {
                        $file = Input::file('poster');
                            
                        $picName = str_random(30).time();
                        $publicPath = public_path('uploads/vacanciePosters/');
                            
                        Image::make($file->getRealPath())->resize(400,null,true)->save($publicPath.$picName.'.'.$file->getClientOriginalExtension());
                            
                        $vacancie->poster = 'uploads/vacanciePosters/'.$picName.'.'.$file->getClientOriginalExtension();
                    }
                        
                        //veiksmīgi saglabātas vakances gadījumā
                    if($vacancie->save())
                    {
                        Session::flash('message-success',trans('messages.vacancie-offer-saved'));
                        return Redirect::to("/viewVacancie/{$vacancie->id}");
                    } 
            }
                //ja neizdevās saglabāt vakanci (nekorekts ievads)
            $data["errors"] = $validator->errors();
            Session::flash('message-fail',trans('messages.couldnt-add-vacancie'));
            return Redirect::route("vacancies/add")->withInput(Input::except('poster'))->with($data);
        }
        
        return View::make("vacancies/add");
    }
    
    //vakances apskatīšana
    public function viewAction($id)
    {   
            //ja atrod konkrēto vakanci
        if(Vacancie::find($id)){
            $vacancie = Vacancie::find($id);
            
            $creator = User::where('id',$vacancie->creator_id)->first();
            $vacancie->creatorName = $creator->username;
            $vacancie->applied = Application::where('vacancie_id',$id)->count();
                //lietotāja rekomendāciju skaits
            $vacancie->userRecommends = Recommendation::where('employer_id',$creator->id)->count();
            
            if(Auth::check()){
                if(Recommendation::where('user_id',Auth::user()->id)->where('employer_id',$creator->id)->first()){
                    $vacancie->recommended = true; //lai skatā varētu uzzināt rekomendācijas statusu
                }
            }
            return View::make("vacancies/view", array('vacancie'=> $vacancie));
        }else{
                //ja konkrētā vakance netika atrasta
            Session::flash('message-fail',trans('messages.non-existent-vacancie'));
            return Redirect::route("vacancies/viewAllVacancies");
        }
    }
    
    //savu vakanču apskatīšana
    public function MyVacanciesAction()
    {
            //pieejams administratoram vai darba devējam
        if(Auth::check() && (Auth::user()->userGroup==1 || Auth::user()->userGroup==2))
        {
            $vacancieCount = Vacancie::where('creator_id',Auth::user()->id)->count();
            $vacancies = Vacancie::where('creator_id',Auth::user()->id)->orderBy('created_at','DESC')->paginate(10);
            $vacancies->count = $vacancieCount;
            
            foreach ($vacancies as $vacancie){
                $applications = Application::where('vacancie_id',$vacancie->id)->get();
                    
                    //katras vakances pieteikumu skaits
                $vacancie->applied = $applications->count();
                
                foreach($applications as $application){
                        //"jauna vakance" paziņojumam
                    if($application->viewed != 1){
                        $vacancie->new = true;
                        break;
                    } 
                }
            }
            
            return View::make("vacancies/myVacancies", array('vacancies'=> $vacancies));
        }
        
            //neatļautas pieejas gadījumā (normālos apstākļos nenotiek)
        Session::flash('message-fail',trans('messages.not-authorized'));
        return Redirect::route("home");
    }
    
    //vakances rediģēšana
    public function editAction($id)
    {
            //pieejams administratoriem vai pašas vakances autoram
        if((Auth::check() && Auth::user()->userGroup==2 && Vacancie::where('id',$id)->where('creator_id',Auth::user()->id)->first()) || Auth::user()->userGroup==1)
        {
            if (Input::server("REQUEST_METHOD") == "POST")
            {
                $vacancieId = Vacancie::find($id);
            
                $validator = Validator::make(Input::all(), [
                    "name" => "required|min:3|max:100|unique:vacancies,name,".$vacancieId->id, //ja nemainās input name, ļauj tāpat saglabāt
                    "text" => "required|min:10|max:1000",
                    "poster" => "image|max:3000|mimes:jpg,jpeg,png,bmp,gif",
                    "phone" => "min:3|max:20",
                    "company" => "max:100"
                ]);
                
                if ($validator->passes())
                {   
                    $vacancie = Vacancie::find($id);
                    $vacancie->name = Input::get('name');
                    $vacancie->text = Input::get('text');
                    $vacancie->phone = Input::get('phone');
                    $vacancie->company = Input::get('company');
                                  
                    if(Input::hasfile('poster'))
                    {
                            //vecās bildes atrašanās vieta
                        if($vacancie->poster){
                           $oldPoster = $vacancie->poster;  
                        }
                            
                        $file = Input::file('poster');

                        $picName = str_random(30).time();
                        $publicPath = public_path('uploads/vacanciePosters/');
                            
                        Image::make($file->getRealPath())->resize(400,null,true)->save($publicPath.$picName.'.'.$file->getClientOriginalExtension());
                            
                        $vacancie->poster = 'uploads/vacanciePosters/'.$picName.'.'.$file->getClientOriginalExtension();
                    }                    
                    
                    if($vacancie->save())
                    {
                            //ja tika augšupielādēta jauna bilde, dzēš iepriekšējo no failu sistēmas
                        if(isset($oldPoster)){
                            File::delete(public_path().'\\'.$oldPoster);
                        }
                    
                        if($vacancie->creator_id==Auth::user()->id){ //ja lietotājs rediģēja sevis pievienoto vakanci
                            Session::flash('message-success',trans('messages.edited-your-vacancie'));
                            return Redirect::route("vacancies/myVacancies");
                        }else{  //ja administrators rediģēja kāda cita lietotāja vakanci
                            Session::flash('message-success',trans('messages.edited-vacancie',['vacancie' => $vacancie->name]));
                            return Redirect::to("/viewVacancie/{$id}");
                        }
                    }
                }
                    //nekorektas ievades gadījumā
                $data["errors"] = $validator->errors();
                Session::flash('message-fail',trans('messages.couldnt-edit-vacancie'));
                return Redirect::to("/editVacancie/{$id}")->withInput(Input::except('poster'))->with($data);
            }
        
            if(Vacancie::find($id)){
                $vacancie = Vacancie::find($id);
                
                    //datu izvadei
                $data["id"] = $vacancie->id;
                $data["poster"] = $vacancie->poster;
                $data["name"] = $vacancie->name;
                $data["text"] = $vacancie->text;
                $data["phone"] = $vacancie->phone;
                $data["company"] = $vacancie->company;
                return View::make("/vacancies/edit")->with($data);
            }else{ //neeksistējošas vakances gadījumā
                Session::flash('message-fail',trans('messages.non-existent-vacancie'));
                return Redirect::route("vacancies/viewAllVacancies");
            }
    
        }else{ //neatļautas pieejas gadījumā
            Session::flash('message-fail',trans('messages.no-access'));
            return Redirect::route("home");
        }     
    }
    
    //vakances dzēšana
    public function deleteAction($id)
    {
            //pieejams administratoriem vai pašas vakances autoram
        if((Auth::check() && Auth::user()->userGroup==2 && Vacancie::where('id',$id)->where('creator_id',Auth::user()->id)->first()) || Auth::user()->userGroup==1)
        {
            if (Input::server("REQUEST_METHOD") == "POST")
            {
                $validator = Validator::make(Input::all(), [
                    "checkbox" => "required"
                ]);
                
                if ($validator->passes())
                {
                    $vacancie = Vacancie::find($id);
                    
                    $checkbox = Input::get('checkbox');
                    
                    if($checkbox)
                    {   
                        $applications = Application::where('vacancie_id',$id);
                        $applications->delete();
                        
                            //veiksmīgas vakances dzēšanas gadījumā
                        if($vacancie->delete())
                        {
                            //dzēš augšupielādēto bildi no failu sistēmas
                            if($vacancie->poster){
                                File::delete(public_path().'\\'.$vacancie->poster);
                            }
                            
                            Session::flash('message-success',trans('messages.deleted-vaccancie',['vacancie' => $vacancie->name]));
                            return Redirect::route("vacancies/viewAllVacancies");                                
                        }else{  //neveiksmīgas dzēšanas gadījumā
                            Session::flash('message-fail',trans('messages.wrong-couldnt-delete-vacancie'));
                            return Redirect::route("vacancies/viewAllVacancies");  
                        }
                    }
                }
                    //neatzīmēta dzešanas apstiprinājuma gadījumā
                $data["errors"] = $validator->errors();
                Session::flash('message-fail',trans('messages.couldnt-delete-vacancie'));
                return Redirect::to("/deleteVacancie/{$id}")->with($data);
                
            }
        
            if(Vacancie::find($id)){
                $vacancie = Vacancie::find($id);
                
                    //datu izvadei
                $data["id"] = $vacancie->id;
                $data["name"] = $vacancie->name;   
                return View::make("vacancies/delete")->with($data); 
            }else{ //neeksistējošas vakances gadījumā
                Session::flash('message-fail',trans('messages.non-existent-vacancie'));
                return Redirect::route("vacancies/viewAllVacancies");
            }  
            
        }else{ //neatļautas pieejas gadījumā
            Session::flash('message-fail',trans('messages.no-access'));
            return Redirect::route("home");
        }
    }
    
}