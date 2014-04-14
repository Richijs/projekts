<?php

use Illuminate\Support\MessageBag;

class UsersController extends BaseController {
    
    /*public function viewProfile($id)
    {
        $user = user::find($id);
        if($user) {        
                     
        return View::make('users.profile',array('user' => $user));
        }
        else {return View::make('errors.404');}
    }*/
    
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
                    //varçtu noderçt glabât userGrupu sesijâ
                    //Session::put('userGroup',Auth::user()->userGroup);
                    Session::flash('message','Veiksmîgi pierakstîjies sistçmâ');
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
            Session::flash('message','Neizdevâs pierakstîties sistçmâ');
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
            if ($validator->passes())
            {
                $credentials = [
                    "email" => Input::get("email")
                ];
                Password::remind($credentials,
                    function($message, $user)
                    {
                        $message->subject('Password Reset!');
                        $message->from("sender@yopmail.com", "sender");
                    }
                );
                $data["requested"] = true;
                
                // Nav jâliek ðeit, bet gan tad, kad tiek nosûtîts e-pasts un pârbaudîts, vai atrodas datubâzç
                Session::flash('message','e-pasts tika nosûtîts uz '.$credentials['email']);
                Session::flash('alert-class','alert-success');
                
                return Redirect::route("home")
                    ->withInput($data);
            }
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
                Session::flash('message','Password changed successfully, '.Auth::user()->username);
                Session::flash('alert-class','alert-success');
                return Redirect::route("users/profile");
            }
            /* messageBag metode ,varbût errorus varçtu pârveidot uz ðo
            $data["errors"] = new MessageBag([
                "email" => ["da"],
                "password" => [
                    "Username and/or password invalid."
                ]
            ]);
            */
            $data["email"] = Input::get("email");
            $data["errors"] = $validator->errors();
                            Session::flash('message','faaail');
                            Session::flash('alert-class','alert-fail');
            return Redirect::to(URL::route("users/reset") . $token)
                ->withInput($data);
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
                "username" => "required",
                "password" => "required|min:6",
                "password_confirmation" => "required|same:password",
                "email" => "required|email"
            ]);
            if ($validator->passes())
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
                $message->from("sender@yopmail.com", "sender");
                $message->to(Input::get('email'), Input::get('username'))->subject('Welcome to the Vakances.lv!');
                });
                
                Auth::login($user);
                Session::flash('message','Registration successfull, '.$user->username);
                Session::flash('alert-class','alert-success');
                return Redirect::route("users/profile");
                
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
            Session::flash('message','Neizdevâs pieregistrçties sistçmâ');
            Session::flash('alert-class','alert-fail');
            return Redirect::route("users/register")
                ->withInput($data);
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
            return Redirect::route("home");
        }
    }
    
    public function viewAllAction()
    {
        $usersCount = User::all()->count();
        if($usersCount>0){ //ja ir vismaz viens users
            $users = User::all();

            foreach($users as $user){
                $user->password = '';
            }
            return View::make("users/viewAllUsers", array('users'=> $users));
        }else{
            Session::flash('message','No registered users');
            Session::flash('alert-class','alert-fail');
            return Redirect::route("home");
        }
    }
    
    public function profileAction()
    {
        return View::make("users/profile");
    }
    
    public function logoutAction()
    {
        Auth::logout();
        Session::flush();
        Session::flash('message','Veiksmîgi izrakstîjies no sistçmas');
        Session::flash('alert-class','alert-success');
        return Redirect::route("home");
    }
}