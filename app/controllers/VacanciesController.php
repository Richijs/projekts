<?php

use Illuminate\Support\MessageBag;
use Intervention\Image\Image;

class VacanciesController extends BaseController {
        
    public function viewAllAction()
    {
        $vacanciesCount = Vacancie::all();
        if($vacanciesCount->count()){ //ja ir vismaz viens vacancy
            $vacancies = Vacancie::paginate(10); //all vacancies + paginate

            foreach($vacancies as $vacancie){
                
                $creator = User::where('id',$vacancie->creator_id)->first();
                $vacancie->creatorName = $creator->username;
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
                "name" => "required|min:3|max:100|alpha_num|unique:vacancies,name",
                "text" => "required|min:10|max:500|alpha_num",
                "poster" => "image|max:3000|mimes:jpg,jpeg,png,bmp,gif"
            ]);
            
            if ($validator->passes())
            {
                
                    $vacancie = new Vacancie;
                    $vacancie->name = Input::get('name');
                    $vacancie->text = Input::get('text');
                    $vacancie->creator_id = Auth::user()->id;
                    
                        if(Input::hasfile('poster'))
                        {
                            
                            $file = Input::file('poster');
                            
                            $extension = preg_replace(array('/image/','/\//'),'',$file->getMimeType()); //izņem "image/" stringu no filetype
                            //$userFolder = sha1($user->id); //user foldera nosaukums ir sha1(userID)
                            $picName = str_random(30).time();
                            $publicPath = public_path('uploads/vacanciePosters/');
                            
                            Image::make($file->getRealPath())->resize(400,null,true)->save($publicPath.$picName.'.'.$extension); //varbut izmantot encode()
                            
                            //$file->move('uploads/profileImages',$picName.'.'.$extension);
                            
                            $vacancie->poster = 'uploads/vacanciePosters/'.$picName.'.'.$extension;
                        }else{
                            
                            //the picture wasnt saved/found 
                            //varbūt pielikt default ? bildi
                            
                        }
                    
                    if($vacancie->save())
                    {
                        Session::flash('message-success','Vacancie offer has been saved');
                        return Redirect::to("/viewVacancie/{$vacancie->id}");
                    }
                    
                /*}else{
                    $data["errors"] = new MessageBag([
                        "username" => ["username or email already exists in database"],
                        "email" => ["username or email already exists in database"]
                    ]);
                    
                    $data["username"] = Input::get("username");
                    $data["email"] = Input::get("email");
                    Session::flash('message-fail','Neizdevās piereģistrēties sistēmā');
                    return Redirect::route("users/register")->withInput($data);
                    
                }*/
                
            }
            
            $data["errors"] = $validator->errors();
            
            $data["name"] = Input::get("name");
            $data["text"] = Input::get("text");
                        
            Session::flash('message-fail','Neizdevās pievienot vakanci');
            return Redirect::route("vacancies/add")->withInput($data)->with($data);
        }
        
        return View::make("vacancies/add");
    }
    
    public function viewAction($id)
    {
        if(Vacancie::find($id)){
            $vacancie = Vacancie::find($id);
            
            $creator = User::where('id',$vacancie->creator_id)->first();
            $vacancie->creatorName = $creator->username;
                
            return View::make("vacancies/view", array('vacancie'=> $vacancie));
        }else{
            Session::flash('message-fail','No vacancie with such ID');
            return Redirect::route("vacancies/viewAllVacancies");
        }
    }
    
    public function MyVacanciesAction()
    {
        //if admin or employer
        if(Auth::check() && (Auth::user()->userGroup==1 || Auth::user()->userGroup==2))
        {
            $vacancieCount = Vacancie::where('creator_id',Auth::user()->id)->count();
            $vacancies = Vacancie::where('creator_id',Auth::user()->id)->paginate(10);
            $vacancies->count = $vacancieCount;
            
            return View::make("vacancies/myVacancies", array('vacancies'=> $vacancies));
        }
        
        //līdz šejienei nekad netiek
        Session::flash('message-fail','Not authorized to do this');
        return Redirect::route("home");
    }
    
}