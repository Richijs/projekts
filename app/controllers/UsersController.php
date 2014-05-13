<?php

use Illuminate\Support\MessageBag;
use Intervention\Image\Image;

class UsersController extends BaseController {
    
    public function loginAction()
    {
        if (Input::server("REQUEST_METHOD") == "POST")
        {
            $validator = Validator::make(Input::all(), [
                "username" => "required",
                "password" => "required"
            ]);
            if ($validator->passes())
            {
                $credentials = [
                    "username" => Input::get("username"),
                    "password" => Input::get("password"),
                    "active" => 1
                ];
                
                //will make a remember cookie
                $remember = (Input::has('remember')) ? true : false;
                
                if (Auth::attempt($credentials,$remember))
                {                    
                        Session::flash('message-success',trans('messages.logged-in'));                    
                        return Redirect::route("users/profile");                  
                }
                                      
                if(User::where('username',$credentials['username'])->where('active','<>',1)->first()){
                    Session::flash('message-fail',trans('messages.not-activated-or-incorrect'));
                }else{
                    Session::flash('message-fail',trans('messages.wrong-user-pass'));
                }
                return Redirect::route("users/login")->withInput(Input::except('password'));
         
            }
            
            $data["errors"] = $validator->errors();
            Session::flash('message-fail',trans('messages.couldnt-login'));
            return Redirect::route("users/login")->withInput(Input::except('password'))->with($data);
        }
        return View::make("users/login");
    }
    
    public function requestAction()
    {
        if (Input::server("REQUEST_METHOD") == "POST")
        {
            $validator = Validator::make(Input::all(), [
                "email" => "required|email|exists:users,email,active,1",  //exists this user email and active = 1
            ]);
                        
            if ($validator->passes())
            {
                $credentials = [
                    "email" => Input::get("email")
                ];
                
                Password::remind($credentials,
                    function($message, $user)
                    {
                        $message->subject('Password Reset!');
                        $message->from("sender@yopmail.com", "sender"); //no
                    }
                );
                
                $data["requested"] = true; //why?
                
                Session::flash('message-success',trans('messages.email-sent-to',['email' => $credentials['email']]));
                
                return Redirect::route("home");
            }
            
            $data["errors"] = $validator->errors();
            
            if(User::where('email',Input::get("email"))->where('active',0)->first()){
                Session::flash('message-fail',trans('messages.not-activated-yet'));
            }else{
                Session::flash('message-fail',trans('messages.couldnt-send-email'));
            }
            return Redirect::route("users/request")->with($data)->withInput(Input::all());
        }
        return View::make("users/request");
    }
    
    public function resetAction()
    {
        $token = "?token=" . Input::get("token");
        $data["token"] = $token;
        
        if (Input::server("REQUEST_METHOD") == "POST")
        {
            //$data["email"] = Input::get("email");
            $validator = Validator::make(Input::all(), [
                "email"                 => "required|email|exists:users,email",
                "password"              => "required|min:6",
                "password_confirmation" => "required|same:password",
                "token"                 => "required|exists:token,token"
            ]);
            if ($validator->passes())
            {
                $credentials = [
                    "email" => Input::get("email"),
                    "password" => Input::get("password"),
                    "password_confirmation" => Input::get("password_confirmation"),
                    "token" => Input::get("token"),
                    "active" => 1
                ];
                Password::reset($credentials, //token pēctam tiek dzēsts no tokens tabulas!
                    function($user, $password)
                    {
                        $user->password = Hash::make($password);
                        if($user->save())
                        {
                            Auth::login($user);
                        }
                        
                    }
                );
                
                if(Auth::check()){
                    Session::flash('message-success',trans('messages.password-changed',['user' => Auth::user()->username]));
                    return Redirect::route("users/profile");
                }else{
                    
                    $data["errors"] = new MessageBag([
                        "email" => [trans('messages.not-your-email-or-not-activated')]
                    ]);
                    
                    Session::flash('message-fail',trans('messages.couldnt-change-pass-tryagain'));
                    return Redirect::to(URL::route("users/reset") . $token)->with($data)->withInput(Input::all());
                }
            }
            
            $data["errors"] = $validator->errors();
            Session::flash('message-fail',trans('messages.couldnt-change-pass'));
            return Redirect::to(URL::route("users/reset") . $token)->withInput(Input::all())->with($data);
        }
        return View::make("users/reset")->with($data);
    }
    
    public function registerAction()
    {
        if (Input::server("REQUEST_METHOD") == "POST")
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
                            
                        $picName = str_random(30).time();
                        $publicPath = public_path('uploads/profileImages/');
                            
                        Image::make($file->getRealPath())->resize(400,null,true)->save($publicPath.$picName.'.'.$file->getClientOriginalExtension()); //varbut izmantot encode()
                            
                        //$file->move('uploads/profileImages',$picName.'.'.$extension);
                            
                        $user->picture = 'uploads/profileImages/'.$picName.'.'.$file->getClientOriginalExtension();
                    }
                    
                if($user->save())
                {
 
                Mail::send('emails.register', array('username'=>Input::get('username'),'code'=>$user->code,'id'=>$user->id), function($message){
                    $message->from("sender@yopmail.com", "sender"); // no
                    $message->to(Input::get('email'), Input::get('username'))->subject('Activate your account on VakancesLV!');
                });
                
                Session::flash('message-success',trans('messages.email-sent-to-complete-registration', ["email" => $user->email]));
                return Redirect::route("home");
                }
                
            }
            
            $data["errors"] = $validator->errors();    
            Session::flash('message-fail',trans('messages.couldnt-register'));
            return Redirect::route("users/register")->withInput(Input::except('picture'))->with($data);
        }
        return View::make("users/register");
    }
    
    public function activateAction()
    {
        $code = Input::get("code"); //gets activation code
        $id = Input::get("id"); //gets user id
                
        $user = User::where('code',$code)->where('active',0)->where('id',$id);
        if($user->count()){
            $user = $user->first();
            
            $user->active = 1;
            $user->code = NULL;
                        
            if($user->save()){
                                                                                 //use - lai varētu piekļūt mainīgajam
                Mail::send('emails.activate', array('username'=>$user->username), function($message) use ($user) {
                    $message->from("sender@yopmail.com", "sender"); // no
                    $message->to($user->email,$user->username)->subject('Succesfully registered at VakancesLV!');
                });
                
                Session::flash('message-success',trans('messages.registered-now-login'));
                return Redirect::route("users/login")->withInput(["username"=>$user->username]);
            }//else ?
            
        }
        Session::flash('message-fail',trans('messages.invalid-link-or-activated'));
        return Redirect::route("home");
    }
    
    public function viewAction($id)
    {
        if(User::find($id)){
            $user = User::find($id);
            $user->password = ''; //negribam skatam padot paroli???
            
            return View::make("users/view", array('user'=> $user));
        }else{
            Session::flash('message-fail',trans('messages.non-existent-user'));
            return Redirect::route("users/viewAllUsers");
        }
    }
    
    public function viewAllAction()
    {
        $usersCount = User::all();
        if($usersCount->count()){ //ja ir vismaz viens users
            $users = User::orderBy('created_at','DESC')->paginate(30); //all users + paginate

            foreach($users as $user){
                $user->password = ''; //needed?
            }
            return View::make("users/viewAllUsers", array('users'=> $users));
        }else{
            return View::make("users/viewAllUsers");
        }
    }
    

    public function editAction($id)
    {
        //if admin or editing self
        if((Auth::check() && Auth::user()->id==$id) || Auth::user()->userGroup==1)
        {
            if (Input::server("REQUEST_METHOD") == "POST")
            {
                //$userId = User::find($id);
                
                $validator = Validator::make(Input::all(), [
                    "username" => "required|min:3|max:50|alpha_num|unique:users,username,".$id, //ignorē sava ID datus! :)
                    "email" => "required|email|unique:users,email,".$id,
                    "firstname" => "required|alpha|max:70",
                    "lastname" => "required|alpha|max:70",
                    "about" => "max:500",
                    "picture" => "image|max:3000|mimes:jpg,jpeg,png,bmp,gif",
                    //"userType" => "required"
               ]);
                if ($validator->passes())
                {   
                    $user = User::find($id);
                    $user->username = Input::get('username');
                    $user->email = Input::get('email');
                    $user->firstname = Input::get('firstname');
                    $user->lastname = Input::get('lastname');
                    $user->about = Input::get('about');
                    
                                                    //admin can't change his own group
                    if (Auth::user()->userGroup==1 && Auth::user()->id!=$id){
                        
                        $prevUserGroup = $user->userGroup;
                        $user->userGroup = Input::get('userGroup');
                    }
                    
                    
                        if(Input::hasfile('picture'))
                        {
                            
                            //old picture link
                            if($user->picture){
                               $oldPic = $user->picture;  
                            }
                            
                            $file = Input::file('picture');
                            
                            $picName = str_random(30).time();
                            $publicPath = public_path('uploads/profileImages/');
                            
                            Image::make($file->getRealPath())->resize(400,null,true)->save($publicPath.$picName.'.'.$file->getClientOriginalExtension()); //varbut izmantot encode()
                            
                            //$file->move('uploads/profileImages',$picName.'.'.$extension);
                            
                            $user->picture = 'uploads/profileImages/'.$picName.'.'.$file->getClientOriginalExtension();
                        }

                    if($user->save())
                    {
                        //deletes old picture from filesystem, if new picture was uploaded
                        if(isset($oldPic)){
                            File::delete(public_path().'\\'.$oldPic);
                        }
                        
                        //if changed userGroup - deletes stuff (except when seeker->admin or employer->admin)
                        if(isset($prevUserGroup) && $prevUserGroup!=$user->userGroup && $user->userGroup!=1)
                        {
                            $recommendations = Recommendation::where('employer_id',$id); //also recommendations
                            $recommendations->delete();  
                            $applications = Application::where('user_id',$id);
                            $applications->delete(); 
                            $seekers = Seeker::where('user_id',$id);
                            $seekers->delete();
                            
                            $vacancies = Vacancie::where('creator_id',$id)->get(); //own vacancies
                            foreach($vacancies as $vacancie){
                                $eachApp = Application::where('vacancie_id',$vacancie->id);
                                $eachApp->delete();
                            }
                            $allVacs = Vacancie::where('creator_id',$id);
                            $allVacs->delete();
                        }
                        
                    
                        if(Auth::user()->id==$id){ //ja editoja sevi
                            Session::flash('message-success',trans('messages.edited-your-profile'));
                            return Redirect::route("users/profile");
                        }else{  //ja admins editoja kādu citu
                            Session::flash('message-success',trans('messages.edited-profile',['user' => $user->username]));
                            return Redirect::to("/viewUser/{$id}");
                        }
                    }
                }
            
                $data["errors"] = $validator->errors();
                Session::flash('message-fail',trans('messages.couldnt-edit-userdata'));
                return Redirect::to("/editUser/{$id}")->withInput(Input::except('picture'))->with($data);
            }
        
            if(User::find($id)){
                $user = User::find($id);
                $data["userId"] = $user->id;
                $data["username"]=$user->username;
                $data["email"]=$user->email;
                $data["firstname"] = $user->firstname;
                $data["lastname"] = $user->lastname;
                $data["about"] = $user->about;
                $data["picture"] = $user->picture;
                
                if (Auth::user()->userGroup==1){
                    $data["userGroup"] = $user->userGroup;
                }
            }else{
                Session::flash('message-fail',trans('messages.non-existent-user'));
                return Redirect::route("users/viewAllUsers");
            }
            return View::make("/users/edit")->with($data);
    
  
        }else{
            Session::flash('message-fail',trans('messages.no-access'));
            return Redirect::route("home");
        }    
        
    }
    
    public function changePassAction()
    {
        if(Auth::check()){
            
            if (Input::server("REQUEST_METHOD") == "POST")
            {
                $validator = Validator::make(Input::all(), [
                    "password"                  => "required",
                    "new_password"              => "required|min:6",
                    "new_password_confirmation" => "required|same:new_password",
                ]);
                if ($validator->passes())
                {
                    $user = User::find(Auth::user()->id);
                    
                    $old_password = Input::get('password');
                    $password = Input::get('new_password');
                    
                        if(Hash::check($old_password,$user->getAuthPassword())){
                            $user->password = Hash::make($password);
                            
                                if($user->save()){
                                    Session::flash('message-success',trans('message.password-changed-authuser'));
                                    return Redirect::route("users/profile");                                
                                } //varbūt pielikt else?
                        }else{
                            $data["errors"] = new MessageBag([
                                "password" => [trans('messages.wrong-current-password')],
                            ]);
                            
                            Session::flash('message-fail',trans('messages.couldnt-change-pass'));
                            return Redirect::route("users/changePass")->with($data);
                        }
                }
                        
                $data["errors"] = $validator->errors();
                Session::flash('message-fail',trans('messages.couldnt-change-pass'));
                return Redirect::route("users/changePass")->with($data);
            }
            
            return View::make("users/changePass"); 
        }
        
        //līdz šejienei normāli nekad netiek
        Session::flash('message-fail',trans('messages.not-logged-in'));
        return Redirect::route("users/login");
    }
    
    public function profileAction()
    {
        if(Auth::check()){
            return View::make("users/profile");
        }
        
        //līdz šejienei nekad netiek
        Session::flash('message-fail',trans('messages.not-logged-in'));
        return Redirect::route("users/login");
    }
    
    public function logoutAction()
    {
        Auth::logout();
        $lastLang = Session::get('locale');
        Session::flush();
        Session::put('locale',$lastLang); //lai pēc izrakstīšanās nemainītos uzstādītā valoda
        
        Session::flash('message-success',trans('messages.logged-out'));
        return Redirect::route("home");
    }
    
    public function deleteAction($id)
    {
        if((Auth::check() && Auth::user()->id==$id) || Auth::user()->userGroup==1)
        {
        
            if (Input::server("REQUEST_METHOD") == "POST")
            {
                $validator = Validator::make(Input::all(), [
                    "password" => "required"
                ]);
                if ($validator->passes())
                {
                    $user = User::find($id);
                    
                    $password = Input::get('password');
                    
                        if(Hash::check($password,Auth::user()->getAuthPassword())){
                            
                            //Ja izdzēš vacancies, vajag arī izdzēst tam piesaistītās applications & pārējo!!!
                            //šim nevajag traucēt arī "jobseeker" lietotāju tipam
                            $recommendations = Recommendation::where('employer_id',$id); //also recommendations
                            $recommendations->delete(); 
                            $myRecommendations = Recommendation::where('user_id',$id); //also recommendations
                            $myRecommendations->delete(); 
                            $applications = Application::where('user_id',$id);
                            $applications->delete(); 
                            $seekers = Seeker::where('user_id',$id);
                            $seekers->delete();
                            
                            $vacancies = Vacancie::where('creator_id',$id)->get(); //own vacancies
                            foreach($vacancies as $vacancie){
                                $eachApp = Application::where('vacancie_id',$vacancie->id);
                                $eachApp->delete();
                            }
                            $allVacs = Vacancie::where('creator_id',$id);
                            $allVacs->delete();
                            
                                                        
                                if($user->delete()){
                                    
                                    //deletes old picture from filesystem
                                    if($user->picture){
                                    File::delete(public_path().'\\'.$user->picture);
                                    }
                                
                                    Session::flash('message-success',trans('messages.deleted-profile',['user' => $user->username]));
                                    return Redirect::route("home");                                
                                } //varbūt pielikt else?
                                
                        }else{
                            $data["errors"] = new MessageBag([
                                "password" => [trans('messages.wrong-password')],
                            ]);
                            
                            Session::flash('message-fail',trans('messages.couldnt-delete-profile'));
                            return Redirect::to("/deleteUser/{$id}")->with($data);
                        }
                }

                $data["errors"] = $validator->errors();
                Session::flash('message-fail',trans('messages.couldnt-delete-profile'));
                return Redirect::to("/deleteUser/{$id}")->with($data);
                
            }
        
            if(User::find($id)){
                $user = User::find($id);
                $data["username"] = $user->username;   
                return View::make("users/delete")->with($data); 
            }else{
                Session::flash('message-fail',trans('messages.non-existent-user'));
                return Redirect::route("users/viewAllUsers");
            }  
            
        }else{
            Session::flash('message-fail',trans('messages.no-access'));
            return Redirect::route("home");
        }   
        
    }
    
}