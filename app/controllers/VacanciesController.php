<?php

use Illuminate\Support\MessageBag;
use Intervention\Image\Image;

class VacanciesController extends BaseController {
        
    public function viewAllAction()
    {
        $vacanciesCount = Vacancie::all();
        if($vacanciesCount->count()){ //ja ir vismaz viens vacancy
            $vacancies = Vacancie::paginate(10); //all users + paginate

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
       /* if (Input::server("REQUEST_METHOD") == "POST")
        {
            $validator = Validator::make(Input::all(), [
                "username" => "required|min:3|max:50|alpha_num|unique:users,username",
                "password" => "required|min:6",
                "password_confirmation" => "required|same:password",
                "firstname" => "required|alpha|max:70",
                "lastname" => "required|alpha|max:70",
                "about" => "max:500",
                "email" => "required|email|unique:users,email",
                "picture" => "image|max:3000|mimes:jpg,jpeg,png,bmp,gif",
                "userType" => "required"
            ]);
            if ($validator->passes())
            {
                
                    $user = new User;
                    $user->username = Input::get('username');
                    $user->email = Input::get('email');
                    $user->password = Hash::make(Input::get('password'));
                    $user->firstname = Input::get('firstname');
                    $user->lastname = Input::get('lastname');
                    $user->about = Input::get('about');
                    $user->userGroup = Input::get('userType');
                    $user->active = 0;
                    $user->code = str_random(60);
                    
                        if(Input::hasfile('picture'))
                        {
                            
                            $file = Input::file('picture');
                            
                            $extension = preg_replace(array('/image/','/\//'),'',$file->getMimeType()); //izņem "image/" stringu no filetype
                            //$userFolder = sha1($user->id); //user foldera nosaukums ir sha1(userID)
                            $picName = str_random(30).time();
                            $publicPath = public_path('uploads/profileImages/');
                            
                            Image::make($file->getRealPath())->resize(200, 200)->save($publicPath.$picName.'.'.$extension); //varbut izmantot encode()
                            
                            //$file->move('uploads/profileImages',$picName.'.'.$extension);
                            
                            $user->picture = 'uploads/profileImages/'.$picName.'.'.$extension;
                        }else{
                            
                            //the picture wasnt saved/found 
                            //varbūt pielikt default ? bildi
                            
                        }
                    
                    if($user->save())
                    {
 
                    Mail::send('emails.activate', array('username'=>Input::get('username'),'code'=>$user->code,'id'=>$user->id), function($message){
                        $message->from("sender@yopmail.com", "sender"); // no
                        $message->to(Input::get('email'), Input::get('username'))->subject('Activate your account on VakancesLV!');
                    });
                
                    Session::flash('message-success','Email has been sent to '.$user->email.' to complete registration');
                    return Redirect::route("home");
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
                
            /*}
            
            $data["errors"] = $validator->errors();
            
            $data["username"] = Input::get("username");
            $data["email"] = Input::get("email");
            $data["firstname"] = Input::get("firstname");
            $data["lastname"] = Input::get("lastname");
            $data["about"] = Input::get("about");
            $data["userType"] = Input::get("userType");
                        
            Session::flash('message-fail','Neizdevās piereģistrēties sistēmā');
            return Redirect::route("users/register")->withInput($data)->with($data);
        }*/
        return View::make("vacancies/add");
    }
    
}