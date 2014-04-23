<?php

use Illuminate\Support\MessageBag;
use Intervention\Image\Image;

class UsersController extends BaseController {
    
    public function loginAction()
    {
        /*$errors = new MessageBag();
        if ($old = Input::old("errors"))
        {
            $errors = $old;
        }
        $data = [
            "errors" => $errors
        ];*/
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
                
                if (Auth::attempt($credentials))
                {                    
                        Session::flash('message-success','Succesfully logged in');                    
                        return Redirect::route("users/profile");                  
                }
                                      
                $data["username"] = Input::get("username");
                Session::flash('message-fail','wrong username or password (or Your account isnt activated)');
                return Redirect::route("users/login")->withInput($data);
         
            }
            
            $data["errors"] = new MessageBag([
                "password" => [
                    "Username and/or password invalid."
                ]
            ]);
            $data["username"] = Input::get("username");
            Session::flash('message-fail','Could not log in');
            return Redirect::route("users/login")->withInput($data)->with($data);
        }
        return View::make("users/login");
    }
    
    public function requestAction()
    {
        /*$data = [
            "requested" => Input::old("requested")
        ];*/
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
                
                //$existsEmail = User::where('email', '=', $credentials['email'])->first();
                //if (isset($existsEmail))
                //{
                
                    Password::remind($credentials,
                        function($message, $user)
                        {
                            $message->subject('Password Reset!');
                            $message->from("sender@yopmail.com", "sender"); //no
                        }
                    );
                    $data["requested"] = true; //why?
                
                
                    Session::flash('message-success','email was sent to '.$credentials['email']);
                
                    return Redirect::route("home");
                /*}else{
                    Session::flash('message-fail','email doesnt exist in the database');
                    return Redirect::route("users/request")->with($data);
                }*/
            }
            
            $data["email"] = Input::get("email");
            $data["errors"] = $validator->errors();
            Session::flash('message-fail','email could not be sent (Maybe Your account isnt activated? check Your email)');
            return Redirect::route("users/request")->with($data)->withInput($data);
        }
        return View::make("users/request");
    }
    
    public function resetAction()
    {
        $token = "?token=" . Input::get("token");
        $data["token"] = $token;
        
        if (Input::server("REQUEST_METHOD") == "POST")
        {
            $data["email"] = Input::get("email");
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
                    Session::flash('message-success','Password changed successfully, '.Auth::user()->username);
                    return Redirect::route("users/profile");
                }else{
                    
                    $data["errors"] = new MessageBag([
                        "email" => ["Not Your email address or account not activated! check Your email"]
                    ]);
                    
                    Session::flash('message-fail','Could not change password, try again');
                    return Redirect::to(URL::route("users/reset") . $token)->with($data)->withInput($data);
                }
            }
            
            $data["errors"] = $validator->errors();
                            Session::flash('message-fail','Couldnt change password');
            return Redirect::to(URL::route("users/reset") . $token)->withInput($data)->with($data);
        }
        return View::make("users/reset")->with($data);
    }
    
    public function registerAction()
    {
        /*$errors = new MessageBag();
        if ($old = Input::old("errors"))
        {
            $errors = $old;
        }
        $data = [
            "errors" => $errors
        ];*/
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
                            
                            //$extension = preg_replace(array('/image/','/\//'),'',$file->getMimeType()); //izņem "image/" stringu no filetype
                            //$userFolder = sha1($user->id); //user foldera nosaukums ir sha1(userID)
                            $picName = str_random(30).time();
                            $publicPath = public_path('uploads/profileImages/');
                            
                            Image::make($file->getRealPath())->resize(400,null,true)->save($publicPath.$picName.'.'.$file->getClientOriginalExtension()); //varbut izmantot encode()
                            
                            //$file->move('uploads/profileImages',$picName.'.'.$extension);
                            
                            $user->picture = 'uploads/profileImages/'.$picName.'.'.$file->getClientOriginalExtension();
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
                
            }
            
            $data["errors"] = $validator->errors();
            
            $data["username"] = Input::get("username");
            $data["email"] = Input::get("email");
            $data["firstname"] = Input::get("firstname");
            $data["lastname"] = Input::get("lastname");
            $data["about"] = Input::get("about");
            $data["userType"] = Input::get("userType");
                        
            Session::flash('message-fail','Neizdevās piereģistrēties sistēmā');
            return Redirect::route("users/register")->withInput($data)->with($data);
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
                Mail::send('emails.register', array('username'=>$user->username), function($message) use ($user) {
                    $message->from("sender@yopmail.com", "sender"); // no
                    $message->to($user->email,$user->username)->subject('Succesfully registered at VakancesLV!');
                });
                
                Session::flash('message-success','Reģistrācija noritējusi veiksmīgi - tagad varat ielogoties');
                return Redirect::route("users/login")->withInput(["username"=>$user->username]);
            }//else ?
            
        }
        Session::flash('message-fail','Darbība neizdevās - nederīga aktivizācijas saite vai lietotājs jau aktivizēts');
        return Redirect::route("home");
    }
    
    public function viewAction($id)
    {
        if(User::find($id)){
            $user = User::find($id);
            
            $user->password = ''; //negribam skatam padot paroli
            
            return View::make("users/view", array('user'=> $user));
        }else{
            Session::flash('message-fail','No user with such ID');
            return Redirect::route("users/viewAllUsers");
        }
    }
    
    public function viewAllAction()
    {
        $usersCount = User::all();
        if($usersCount->count()){ //ja ir vismaz viens users
            $users = User::paginate(10); //all users + paginate

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
        /*$errors = new MessageBag();
        if ($old = Input::old("errors"))
        {
            $errors = $old;
        }
        $data = ["errors" => $errors];
        */
        
    //if admin or editing self
    if((Auth::check() && Auth::user()->id==$id) || Auth::user()->userGroup==1)
    {
        if (Input::server("REQUEST_METHOD") == "POST")
        {
            $validator = Validator::make(Input::all(), [
                "username" => "required|alpha_num|unique:users,username,".$id, //ignorē sava ID datus! :)
                "email" => "required|email|unique:users,email,".$id
            ]);
            if ($validator->passes())
            {   // <> -> not equal
                /*$existsEmail = DB::table('users')->where('email',Input::get('email'))->where('id','<>',$id)->first();
                $existsUsername = DB::table('users')->where('username',Input::get('username'))->where('id','<>',$id)->first();
                if (!$existsEmail && !$existsUsername)
                {*/
                    $user = User::find($id);
                    $user->username = Input::get('username');
                    $user->email = Input::get('email');
                                  
                    //$data["username"]=$user->username;  ??
                    //$data["email"]=$user->email;        ??
                    if($user->save())
                    {
                    
                        if(Auth::user()->id==$id){ //ja editoja sevi
                            Session::flash('message-success','Edited Your profile successfully');
                            return Redirect::route("users/profile");
                        }else{  //ja admins editoja kādu citu
                            Session::flash('message-success','Edited '.$user->username.' profile successfully');
                            return Redirect::to("/viewUser/{$id}");
                        }
                    }
                /*}else{
                    $data["errors"] = new MessageBag([
                        "username" => ["this username or email is already taken by another user"],
                        "email" => ["this username or email is already taken by another user"]
                    ]);
                    
                    $data["username"] = Input::get("username");
                    $data["email"] = Input::get("email");
                    Session::flash('message-fail','Neizdevās labot lietotāju');
                    return Redirect::to("/editUser/{$id}")->withInput($data);
                    
                }*/
                
            }
            
            $data["errors"] = $validator->errors();
            
            $data["username"] = Input::get("username");
            $data["email"] = Input::get("email");
            Session::flash('message-fail','Editing user data was not successfull');
            return Redirect::to("/editUser/{$id}")->withInput($data)->with($data);
        }
        
        if(User::find($id)){
            $user = User::find($id);
            $data["username"]=$user->username;
            $data["email"]=$user->email;
        }else{
            Session::flash('message-fail','No user with such ID');
            return Redirect::route("users/viewAllUsers");
        }
        return View::make("/users/edit")->with($data);
    
  
    }else{
        Session::flash('message-fail','No Access to action');
        return Redirect::route("home");
    }    
        
        
    }
    
    public function changePassAction()
    {
        if(Auth::check()){
            
            /*$errors = new MessageBag();
            if ($old = Input::old("errors"))
            {
                $errors = $old;
            }
            $data = [
                "errors" => $errors
            ];*/
            if (Input::server("REQUEST_METHOD") == "POST")
            {
                $validator = Validator::make(Input::all(), [
                    "password"                  => "required|",
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
                                    Session::flash('message-success','Your Password changed successfully');
                                    return Redirect::route("users/profile");                                
                                } //varbūt pielikt else?
                        }else{
                            $data["errors"] = new MessageBag([
                                "password" => ["Wrong current password"],
                            ]);
                            
                            Session::flash('message-fail','Could not change password');
                            return Redirect::route("users/changePass")->with($data);
                        }
                }
                        
                $data["errors"] = $validator->errors();
                Session::flash('message-fail','Could not change password');
                return Redirect::route("users/changePass")->with($data);
            }
            
            return View::make("users/changePass"); 
        }
        
        //līdz šejienei normāli nekad netiek
        Session::flash('message-fail','You are not logged in');
        return Redirect::route("users/login");
    }
    
    public function profileAction()
    {
        if(Auth::check()){
            return View::make("users/profile");
        }
        
        //līdz šejienei nekad netiek
        Session::flash('message-fail','You are not logged in');
        return Redirect::route("users/login");
    }
    
    public function logoutAction()
    {
        Auth::logout();
        $lastLang = Session::get('locale');
        Session::flush();
        Session::put('locale',$lastLang); //lai pēc izrakstīšanās nemainītos uzstādītā valoda
        
        Session::flash('message-success','Succesfully logged out');
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
                            
                            //šis netraucē arī "jobseeker" lietotāju tipam
                            $vacancies = Vacancie::where('creator_id',$id); //first deletes vacancies
                            $vacancies->delete();
                            
                            if($user->delete()){
                                    Session::flash('message-success','Profile "'.$user->username.'" deleted succesfully');
                                    return Redirect::route("home");                                
                                } //varbūt pielikt else?
                                
                        }else{
                            $data["errors"] = new MessageBag([
                                "password" => ["Wrong password"],
                            ]);
                            
                            Session::flash('message-fail','Could not delete Profile');
                            return Redirect::to("/deleteUser/{$id}")->with($data);
                        }
                }
                
                $user = User::find($id);
                $data["username"] = $user->username;  
                $data["errors"] = $validator->errors();
                Session::flash('message-fail','Could not delete profile');
                return Redirect::to("/deleteUser/{$id}")->with($data);
                
            }
        
            if(User::find($id)){
                $user = User::find($id);
                $data["username"] = $user->username;   
                return View::make("users/delete")->with($data); 
            }else{
                Session::flash('message-fail','No user with such ID');
                return Redirect::route("users/viewAllUsers");
            }  
            
        }else{
            Session::flash('message-fail','No Access to action');
            return Redirect::route("home");
        }   
        
    }
    
}