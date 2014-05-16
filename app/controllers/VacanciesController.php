<?php

//use Illuminate\Support\MessageBag;
use Intervention\Image\Image;

class VacanciesController extends BaseController {
        
    public function viewAllAction()
    {
        $vacanciesCount = Vacancie::all();
        if($vacanciesCount->count()){ //ja ir vismaz viens vacancy
            $vacancies = Vacancie::orderBy('created_at','DESC')->paginate(10); //all vacancies + paginate

            foreach($vacancies as $vacancie){
                
                $creator = User::where('id',$vacancie->creator_id)->first();
                $vacancie->creatorName = $creator->username;
                
                //cik userim ir recommendo
                $vacancie->userRecommends = Recommendation::where('employer_id',$creator->id)->count();
                //cik daudz katrai vakancei pieteikušies
                $vacancie->applied = Application::where('vacancie_id',$vacancie->id)->count();
                
                if(Auth::check()){
                    if(Recommendation::where('user_id',Auth::user()->id)->where('employer_id',$creator->id)->first()){
                        $vacancie->recommended = true; //lai var displayot (recommend/unrecommend)
                    }
                }
            }

            
            
            return View::make("vacancies/viewAllVacancies", array('vacancies'=> $vacancies));
        }else{
            return View::make("vacancies/ViewAllVacancies");
        }
    }
    
    public function AddAction()
    {
        if (Input::server("REQUEST_METHOD") == "POST")
        {
            $validator = Validator::make(Input::all(), [
                "name" => "required|min:3|max:100|unique:vacancies,name",
                "text" => "required|min:10|max:500",
                "poster" => "image|max:3000|mimes:jpg,jpeg,png,bmp,gif",
                "phone" => "min:3|max:20",
                "company" => "max:200"
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
                            
                            Image::make($file->getRealPath())->resize(400,null,true)->save($publicPath.$picName.'.'.$file->getClientOriginalExtension()); //varbut izmantot encode()
                            
                            //$file->move('uploads/profileImages',$picName.'.'.$extension);
                            
                            $vacancie->poster = 'uploads/vacanciePosters/'.$picName.'.'.$file->getClientOriginalExtension();
                        }
                    
                    if($vacancie->save())
                    {
                        Session::flash('message-success',trans('messages.vacancie-offer-saved'));
                        return Redirect::to("/viewVacancie/{$vacancie->id}");
                    }
                
            }
            
            $data["errors"] = $validator->errors();
            Session::flash('message-fail',trans('messages.couldnt-add-vacancie'));
            return Redirect::route("vacancies/add")->withInput(Input::except('poster'))->with($data);
        }
        
        return View::make("vacancies/add");
    }
    
    public function viewAction($id)
    {
        if(Vacancie::find($id)){
            $vacancie = Vacancie::find($id);
            
            $creator = User::where('id',$vacancie->creator_id)->first();
            $vacancie->creatorName = $creator->username;
            $vacancie->applied = Application::where('vacancie_id',$id)->count();
            //cik userim ir recommendo
            $vacancie->userRecommends = Recommendation::where('employer_id',$creator->id)->count();
            
            if(Auth::check()){
                    if(Recommendation::where('user_id',Auth::user()->id)->where('employer_id',$creator->id)->first()){
                        $vacancie->recommended = true; //lai var displayot (recommend/unrecommend)
                    }
                }
            return View::make("vacancies/view", array('vacancie'=> $vacancie));
        }else{
            Session::flash('message-fail',trans('messages.non-existent-vacancie'));
            return Redirect::route("vacancies/viewAllVacancies");
        }
    }
    
    public function MyVacanciesAction()
    {
        //if admin or employer
        if(Auth::check() && (Auth::user()->userGroup==1 || Auth::user()->userGroup==2))
        {
            $vacancieCount = Vacancie::where('creator_id',Auth::user()->id)->count();
            $vacancies = Vacancie::where('creator_id',Auth::user()->id)->orderBy('created_at','DESC')->paginate(10);
            $vacancies->count = $vacancieCount;
            
            //cik daudz katrai vakancei pieteikušies
            foreach ($vacancies as $vacancie){
                $applications = Application::where('vacancie_id',$vacancie->id)->get();
                
                $vacancie->applied = $applications->count();
                
                foreach($applications as $application){
                    
                    if($application->viewed != 1){
                        $vacancie->new = true;
                        break;
                    }
                    
                }
            }
            
            
            return View::make("vacancies/myVacancies", array('vacancies'=> $vacancies));
        }
        
        //līdz šejienei nekad netiek
        Session::flash('message-fail',trans('messages.not-authorized'));
        return Redirect::route("home");
    }
    
    //todo fix smth
    public function editAction($id)
    {

        //if admin or editing own vacancie
        if((Auth::check() && Auth::user()->userGroup==2 && Vacancie::where('id',$id)->where('creator_id',Auth::user()->id)->first()) || Auth::user()->userGroup==1)
        {
            if (Input::server("REQUEST_METHOD") == "POST")
            {
                $vacancieId = Vacancie::find($id);
            
                $validator = Validator::make(Input::all(), [
                    "name" => "required|min:3|max:100|unique:vacancies,name,".$vacancieId->id, //ja nemainās input name, ļauj tāpat saglabāt
                    "text" => "required|min:10|max:500",
                    "poster" => "image|max:3000|mimes:jpg,jpeg,png,bmp,gif",
                    "phone" => "min:3|max:20",
                    "company" => "max:200"
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
                            //old picture link
                            if($vacancie->poster){
                               $oldPoster = $vacancie->poster;  
                            }
                            
                            $file = Input::file('poster');
                            
                            //$extension = preg_replace(array('/image/','/\//'),'',$file->getMimeType()); //izņem "image/" stringu no filetype
                            //$userFolder = sha1($user->id); //user foldera nosaukums ir sha1(userID)
                            $picName = str_random(30).time();
                            $publicPath = public_path('uploads/vacanciePosters/');
                            
                            Image::make($file->getRealPath())->resize(400,null,true)->save($publicPath.$picName.'.'.$file->getClientOriginalExtension()); //varbut izmantot encode()
                            
                            //$file->move('uploads/profileImages',$picName.'.'.$extension);
                            
                            $vacancie->poster = 'uploads/vacanciePosters/'.$picName.'.'.$file->getClientOriginalExtension();
                        }else{
                            
                            //the picture wasnt saved/found 
                                                        
                        }
                    
                    
                    if($vacancie->save())
                    {
                        
                        //deletes old picture from filesystem, if new picture was uploaded
                        if(isset($oldPoster)){
                            File::delete(public_path().'\\'.$oldPoster);
                        }
                    
                        if($vacancie->creator_id==Auth::user()->id){ //ja editoja sevi
                            Session::flash('message-success',trans('messages.edited-your-vacancie'));
                            return Redirect::route("vacancies/myVacancies");
                        }else{  //ja admins editoja kādu citu
                            Session::flash('message-success',trans('messages.edited-vacancie',['vacancie' => $vacancie->name]));
                            return Redirect::to("/viewVacancie/{$id}");
                        }
                    }
                
                }
            
                $data["errors"] = $validator->errors();
                Session::flash('message-fail',trans('messages.couldnt-edit-vacancie'));
                return Redirect::to("/editVacancie/{$id}")->withInput(Input::except('poster'))->with($data);
            }
        
            if(Vacancie::find($id)){
                $vacancie = Vacancie::find($id);
                $data["id"] = $vacancie->id;
                $data["poster"] = $vacancie->poster;
                $data["name"] = $vacancie->name;
                $data["text"] = $vacancie->text;
                $data["phone"] = $vacancie->phone;
                $data["company"] = $vacancie->company;
                return View::make("/vacancies/edit")->with($data);
            }else{
                Session::flash('message-fail',trans('messages.non-existent-vacancie'));
                return Redirect::route("vacancies/viewAllVacancies");
            }
    
  
        }else{
            Session::flash('message-fail',trans('messages.no-access'));
            return Redirect::route("home");
        }    
        
    }
    
    public function deleteAction($id)
    {
        //if admin or deleting own vacancie
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
                        
                        if($vacancie->delete())
                        {
                            //deletes old poster
                            if($vacancie->poster){
                                File::delete(public_path().'\\'.$vacancie->poster);
                            }
                            
                            Session::flash('message-success',trans('messages.deleted-vaccancie',['vacancie' => $vacancie->name]));
                            return Redirect::route("vacancies/viewAllVacancies");                                
                        }else{
                            //varbūt pielikt else?
                            Session::flash('message-fail',trans('messages.wrong-couldnt-delete-vacancie'));
                            return Redirect::route("vacancies/viewAllVacancies");  
                        }
                    }
                }
                
                $data["errors"] = $validator->errors();
                Session::flash('message-fail',trans('messages.couldnt-delete-vacancie'));
                return Redirect::to("/deleteVacancie/{$id}")->with($data);
                
            }
        
            if(Vacancie::find($id)){
                $vacancie = Vacancie::find($id);
                $data["id"] = $vacancie->id;
                $data["name"] = $vacancie->name;   
                return View::make("vacancies/delete")->with($data); 
            }else{
                Session::flash('message-fail',trans('messages.non-existent-vacancie'));
                return Redirect::route("vacancies/viewAllVacancies");
            }  
            
        }else{
            Session::flash('message-fail',trans('messages.no-access'));
            return Redirect::route("home");
        }
    }
    
    
}