<?php

use Illuminate\Support\MessageBag;

class UsersController extends BaseController {
    
    public function loginAction()
    {
        $errors = new MessageBag();
        if ($old = Input::old("errors"))
        {
            $errors = $old;
        }
        $data = [
            "errors" => $errors
        ];
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
                    "password" => Input::get("password")
                ];
                if (Auth::attempt($credentials))
                {
                    Session::flash('message','Succesfully logged in');
                    Session::flash('alert-class','alert-success');
                    
                    return Redirect::route("users/profile");
                }
            }
            $data["errors"] = new MessageBag([
                "password" => [
                    "Username and/or password invalid."
                ]
            ]);
            $data["username"] = Input::get("username");
            Session::flash('message','Could not log in');
            Session::flash('alert-class','alert-fail');
            return Redirect::route("users/login")
                ->withInput($data);
        }
        return View::make("users/login", $data);
    }
    
    public function requestAction()
    {
        $data = [
            "requested" => Input::old("requested")
        ];
        if (Input::server("REQUEST_METHOD") == "POST")
        {
            $validator = Validator::make(Input::all(), [
                "email" => "required|email"
            ]);
            $data["email"] = Input::get("email");
            if ($validator->passes())
            {
                $credentials = [
                    "email" => Input::get("email")
                ];
                
                $existsEmail = User::where('email', '=', $credentials['email'])->first();
                if (isset($existsEmail))
                {
                
                    Password::remind($credentials,
                        function($message, $user)
                        {
                            $message->subject('Password Reset!');
                            $message->from("sender@yopmail.com", "sender"); //no
                        }
                    );
                    $data["requested"] = true;
                
                
                    Session::flash('message','email was sent to '.$credentials['email']);
                    Session::flash('alert-class','alert-success');
                
                    return Redirect::route("home")->withInput($data);
                }else{
                    Session::flash('message','email doesnt exist in the database');
                    Session::flash('alert-class','alert-fail');
                    return Redirect::route("users/request")->withInput($data);
                }
            }
            
            Session::flash('message','email could not be sent, try again');
            Session::flash('alert-class','alert-fail');
            return Redirect::route("users/request")->withInput($data);
        }
        return View::make("users/request", $data);
    }
    
    public function resetAction()
    {
        $token = "?token=" . Input::get("token");
        $errors = new MessageBag();
        if ($old = Input::old("errors"))
        {
            $errors = $old;
        }
        $data = [
            "token"  => $token,
            "errors" => $errors
        ];
        if (Input::server("REQUEST_METHOD") == "POST")
        {
            $validator = Validator::make(Input::all(), [
                "email"                 => "required|email",
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
                    "token" => Input::get("token")
                ];
                Password::reset($credentials,
                    function($user, $password)
                    {
                        $user->password = Hash::make($password);
                        $user->save();
                        Auth::login($user);
                        
                    }
                );
                if(Auth::check()){
                    Session::flash('message','Password changed successfully, '.Auth::user()->username);
                    Session::flash('alert-class','alert-success');
                    return Redirect::route("users/profile");
                }else{
                    
                    $data["errors"] = new MessageBag([
                        "email" => ["Not Your email"]
                    ]);
                    
                    Session::flash('message','Could not change password, try again');
                    Session::flash('alert-class','alert-fail');
                    return Redirect::to(URL::route("users/reset") . $token)->withInput($data);
                }
            }
             //messageBag erroru metode
            /*$data["errors"] = new MessageBag([
                "token" => ["token required"],
                "email" => ["email must be set"
                            ],
                "password" => [
                    "password must be over x characters"
                ],
                "password_confirmation" => ["pass other"]
            ]);*/
            
            $data["email"] = Input::get("email");
            $data["errors"] = $validator->errors();
                            Session::flash('message','faaail');
                            Session::flash('alert-class','alert-fail');
            return Redirect::to(URL::route("users/reset") . $token)->withInput($data);
        }
        return View::make("users/reset", $data);
    }
    
    public function registerAction()
    {
        $errors = new MessageBag();
        if ($old = Input::old("errors"))
        {
            $errors = $old;
        }
        $data = [
            "errors" => $errors
        ];
        if (Input::server("REQUEST_METHOD") == "POST")
        {
            $validator = Validator::make(Input::all(), [
                "username" => "required|alpha_num",
                "password" => "required|min:6",
                "password_confirmation" => "required|same:password",
                "email" => "required|email"
            ]);
            if ($validator->passes())
            {
                $existsEmail = User::where('email', '=', Input::get('email'))->pluck('email');
                $existsUsername = User::where('username', '=', Input::get('username'))->pluck('username');
                if ($existsEmail!=Input::get('email') && $existsUsername!=Input::get('username'))
                {
                    $user = new User;
                    $user->username = Input::get('username');
                    $user->email = Input::get('email');
                    $user->password = Hash::make(Input::get('password'));
                    $user->userGroup = 3;
                    $user->status = 1;
                    if($user->save())
                    {
 
                    Mail::send('emails.register', array('username'=>Input::get('username')), function($message){
                    $message->from("sender@yopmail.com", "sender"); // no
                    $message->to(Input::get('email'), Input::get('username'))->subject('Welcome to the Vakances.lv!');
                    });
                
                    Auth::login($user);
                    Session::flash('message','Registration successfull, '.$user->username);
                    Session::flash('alert-class','alert-success');
                    return Redirect::route("users/profile");
                    }
                    
                }else{
                    $data["errors"] = new MessageBag([
                        "username" => ["username or email already exists in database"],
                        "email" => ["username or email already exists in database"]
                    ]);
                    
                    $data["username"] = Input::get("username");
                    $data["email"] = Input::get("email");
                    Session::flash('message','Neizdevās piereģistrēties sistēmā');
                    Session::flash('alert-class','alert-fail');
                    return Redirect::route("users/register")->withInput($data);
                    
                }
                
            }
            
            /*$data["errors"] = new MessageBag([
                "username" => [ "username invalid."
                ],
                "password" => [ "password invalid."
                ],
                "password_confirmation" => [  "password confirmation invalid."
                ],
                "email" => [ "email invalid."
                ]
            ]);*/
            $data["errors"] = $validator->errors();
            
            $data["username"] = Input::get("username");
            $data["email"] = Input::get("email");
            Session::flash('message','Neizdevās piereģistrēties sistēmā');
            Session::flash('alert-class','alert-fail');
            return Redirect::route("users/register")->withInput($data);
        }
        return View::make("users/register", $data);
    }
    
    public function viewAction($id)
    {
        if(User::find($id)){
            $user = User::find($id);
            
            $user->password = ''; //negribam skatam padot paroli
            
            return View::make("users/view", array('user'=> $user));
        }else{
            Session::flash('message','No user with such ID');
            Session::flash('alert-class','alert-fail');
            return Redirect::route("users/viewAllUsers");
        }
    }
    
    public function viewAllAction()
    {
        $usersCount = User::all()->count();
        if($usersCount>0){ //ja ir vismaz viens users
            $users = User::paginate(5); //all users + paginate

            foreach($users as $user){
                $user->password = '';
            }
            return View::make("users/viewAllUsers", array('users'=> $users));
        }else{

            Session::flash('message','No registered users');
            Session::flash('alert-class','alert-fail');
            return View::make("users/viewAllUsers");
        }
    }
    

    public function editAction($id)
    {
        $errors = new MessageBag();
        if ($old = Input::old("errors"))
        {
            $errors = $old;
        }
        $data = ["errors" => $errors];
        
        if (Input::server("REQUEST_METHOD") == "POST")
        {
            $validator = Validator::make(Input::all(), [
                "username" => "required",
                "email" => "required|email"
            ]);
            if ($validator->passes())
            {   // <> -> not equal
                $existsEmail = DB::table('users')->where('email',Input::get('email'))->where('id','<>',$id)->first();
                $existsUsername = DB::table('users')->where('username',Input::get('username'))->where('id','<>',$id)->first();
                if (!$existsEmail && !$existsUsername)
                {
                    $user = User::find($id);
                    $user->username = Input::get('username');
                    $user->email = Input::get('email');
                    $user->userGroup = 3;
                    $user->status = 1;
                
                    //$data["username"]=$user->username;  ??
                    //$data["email"]=$user->email;        ??
                    if($user->save())
                    {
                        Session::flash('alert-class','alert-success');
                    
                        if(Auth::user()->id==$id){ //ja editoja sevi
                            Session::flash('message','Edited Your profile successfully');
                            return Redirect::route("users/profile");
                        }else{  //ja admins editoja kādu citu
                            Session::flash('message','Edited '.$user->username.' profile successfully');
                            return Redirect::to("/viewUser/{$id}");
                        }
                    }
                }else{
                    $data["errors"] = new MessageBag([
                        "username" => ["this username or email is already taken by another user"],
                        "email" => ["this username or email is already taken by another user"]
                    ]);
                    
                    $data["username"] = Input::get("username");
                    $data["email"] = Input::get("email");
                    Session::flash('message','Neizdevās labot lietotāju');
                    Session::flash('alert-class','alert-fail');
                    return Redirect::to("/editUser/{$id}")->withInput($data);
                    
                }
                
            }
            
            $data["errors"] = $validator->errors();
            
            $data["username"] = Input::get("username");
            $data["email"] = Input::get("email");
            Session::flash('message','Editing user data was not successfull');
            Session::flash('alert-class','alert-fail');
            return Redirect::to("/editUser/{$id}")->withInput($data);
        }
        
        if(User::find($id)){
            $user = User::find($id);
            $data["username"]=$user->username;
            $data["email"]=$user->email;
        }else{
            Session::flash('message','No user with such ID');
            Session::flash('alert-class','alert-fail');
            return Redirect::route("users/viewAllUsers");
        }
        return View::make("/users/edit")->with($data);
    }
    
    public function changePassAction()
    {
        if(Auth::check()){
            
            $errors = new MessageBag();
            if ($old = Input::old("errors"))
            {
                $errors = $old;
            }
            $data = [
                "errors" => $errors
            ];
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
                                    Session::flash('message','Your Password changed successfully');
                                    Session::flash('alert-class','alert-success');
                                    return Redirect::route("users/profile");                                
                                } 
                        }
                }
                        
                $data["errors"] = $validator->errors();
                Session::flash('message','Could not change password');
                Session::flash('alert-class','alert-fail');
                return Redirect::route("users/changePass")->with($data);
            }
            
            return View::make("users/changePass"); 
        }
        
        //līdz šejienei normāli nekad netiek
        Session::flash('message','You are not logged in');
        Session::flash('alert-class','alert-fail');
        return Redirect::route("users/login");
    }
    
    public function profileAction()
    {
        if(Auth::check()){
            return View::make("users/profile");
        }
        
        //līdz šejienei nekad netiek
        Session::flash('message','You are not logged in');
        Session::flash('alert-class','alert-fail');
        return Redirect::route("users/login");
    }
    
    public function logoutAction()
    {
        Auth::logout();
        $lastLang = Session::get('locale');
        Session::flush();
        Session::put('locale',$lastLang); //lai pēc izrakstīšanās nemainītos uzstādītā valoda
        
        Session::flash('message','Succesfully logged out');
        Session::flash('alert-class','alert-success');
        return Redirect::route("home");
    }
}