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
                        return Redirect::route("users/profile")->with('message','IR'); //nestrâdâ flash message
                    }
                );
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
    
    public function profileAction()
    {
        return View::make("users/profile");
    }
    
    public function logoutAction()
    {
        Auth::logout();
        Session::flash('message','Veiksmîgi izrakstîjies no sistçmas');
        Session::flash('alert-class','alert-success');
        return Redirect::route("home");
    }
}