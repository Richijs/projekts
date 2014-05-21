<?php

use Illuminate\Support\MessageBag;
use Intervention\Image\Image;

class UsersController extends BaseController {
    
    //lietotāja pierakstīšanās
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
                
                    //ja atzīmēts "atcerēties mani", veidos atcerēšanās "cepumu"
                $remember = (Input::has('remember')) ? true : false;
                
                    //veiksmīgas pierakstīšanās gadījumā
                if (Auth::attempt($credentials,$remember))
                {                    
                        Session::flash('message-success',trans('messages.logged-in'));                    
                        return Redirect::route("users/profile");                  
                }
                    //neaktitivizēta lietotāja/nepareizas paroles gadījumā
                if(User::where('username',$credentials['username'])->where('active','<>',1)->first()){
                    Session::flash('message-fail',trans('messages.not-activated-or-incorrect'));
                }else{ //nekorekta lietotājvārda/paroles gadījumā
                    Session::flash('message-fail',trans('messages.wrong-user-pass'));
                }
                return Redirect::route("users/login")->withInput(Input::except('password'));
            }
                //kļūdainu ieejas datu gadījumā
            $data["errors"] = $validator->errors();
            Session::flash('message-fail',trans('messages.couldnt-login'));
            return Redirect::route("users/login")->withInput(Input::except('password'))->with($data);
        }
        return View::make("users/login");
    }
    
    //pieprasīt lietotāja paroles maiņu (neautorizēts)
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
                
                    //nosūta paroles maiņas epastu
                Password::remind($credentials,
                    function($message, $user)
                    {
                        $message->subject('Password Reset!');
                        $message->from("sender@yopmail.com", "sender"); //no
                    }
                );
                
                $data["requested"] = true;
                Session::flash('message-success',trans('messages.email-sent-to',['email' => $credentials['email']]));
                
                return Redirect::route("home");
            }
            
            $data["errors"] = $validator->errors();
            
                //neautorizēta lietotāja gadījumā
            if(User::where('email',Input::get("email"))->where('active',0)->first()){
                Session::flash('message-fail',trans('messages.not-activated-yet'));
            }else{ //neeksistējoša,nepareiza e-pasta gadījumā
                Session::flash('message-fail',trans('messages.couldnt-send-email'));
            }
            return Redirect::route("users/request")->with($data)->withInput(Input::all());
        }
        return View::make("users/request");
    }
    
    //lietotāja paroles maiņa (neautorizēts)
    public function resetAction()
    {
            //nepieciešams tālākai pārvirzei kļūdu gadījumā
        $token = "?token=" . Input::get("token");
        $data["token"] = $token;
        
        if (Input::server("REQUEST_METHOD") == "POST")
        {
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
                    
                    //nomaina lietotāja paroli, pēctam dzēšot ierakstu no "tokens" tabulas
                Password::reset($credentials,
                    function($user, $password)
                    {
                        $user->password = Hash::make($password);
                        if($user->save()) //ja parole tiek veiksmīgi nomainīta, automātiski pieraksta lietotāju
                        {
                            Auth::login($user);
                        }
                    }
                );
                
                    //ja lietotājs tika pierakstīts
                if(Auth::check()){
                    Session::flash('message-success',trans('messages.password-changed',['user' => Auth::user()->username]));
                    return Redirect::route("users/profile");
                }else{ //ja lietotājs netika pierakstīts un radās kļūda
                    
                    $data["errors"] = new MessageBag([
                        "email" => [trans('messages.not-your-email-or-not-activated')]
                    ]);
                    
                    Session::flash('message-fail',trans('messages.couldnt-change-pass-tryagain'));
                    return Redirect::to(URL::route("users/reset") . $token)->with($data)->withInput(Input::all());
                }
            }
                //nekorektu ievades datu gadījumā
            $data["errors"] = $validator->errors();
            Session::flash('message-fail',trans('messages.couldnt-change-pass'));
            return Redirect::to(URL::route("users/reset") . $token)->withInput(Input::all())->with($data);
        }
        return View::make("users/reset")->with($data);
    }
    
    //lietotāja reģistrācija
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

                        $user->picture = 'uploads/profileImages/'.$picName.'.'.$file->getClientOriginalExtension();
                    }
                    
                    //ja lietotājs tika saglabāts
                if($user->save())
                {
                        //tiek nosūtīts e-pasts, ar kuru tālāk iespējams veikt profila aktivizāciju
                    Mail::send('emails.register', array('username'=>Input::get('username'),'code'=>$user->code,'id'=>$user->id), function($message){
                        $message->from("sender@yopmail.com", "sender"); // no
                        $message->to(Input::get('email'), Input::get('username'))->subject('Activate your account on VakancesLV!');
                    });
                
                Session::flash('message-success',trans('messages.email-sent-to-complete-registration', ["email" => $user->email]));
                return Redirect::route("home");
                }
            }
                //nekorektu ievades datu gadījumā
            $data["errors"] = $validator->errors();    
            Session::flash('message-fail',trans('messages.couldnt-register'));
            return Redirect::route("users/register")->withInput(Input::except('picture'))->with($data);
        }
        return View::make("users/register");
    }
    
    //lietotāja profila aktivizācija
    public function activateAction()
    {
        $code = Input::get("code"); //iegūst aktivizācijas kodu
        $id = Input::get("id"); //iegūst lietotāja id numuru
                
            //ja eksistē neaktivizēts lietotājs ar šādu aktivizācijas kodu un lietotāja id numuru
        $user = User::where('code',$code)->where('active',0)->where('id',$id);
        if($user->count()){
            $user = $user->first();
            
            $user->active = 1;
            $user->code = NULL;
                        
                //ja profilam veiksmīgi tiek mainīts statuss uz "aktivizēts"
            if($user->save()){
                    
                    //tiek izsūtīts sveiciena e-pasts
                Mail::send('emails.activate', array('username'=>$user->username), function($message) use ($user) {
                    $message->from("sender@yopmail.com", "sender"); // no
                    $message->to($user->email,$user->username)->subject('Succesfully registered at VakancesLV!');
                });
                    //lietotājs tiek pārvirzīts uz pierakstīšanās lapu
                Session::flash('message-success',trans('messages.registered-now-login'));
                return Redirect::route("users/login")->withInput(["username"=>$user->username]);
            }
        }
            //neeksistējošas saites vai jau aktivizēta lietotāja profila gadījumā
        Session::flash('message-fail',trans('messages.invalid-link-or-activated'));
        return Redirect::route("home");
    }
    
    //lietotāja profila apskate
    public function viewAction($id)
    {   
            //ja sistēmā tiek atrasts lietotājs ar šādu id numuru
        if(User::find($id)){
            $user = User::find($id);
            $user->userRecommends = Recommendation::where('employer_id',$user->id)->count();
            
            if(Auth::check() && Recommendation::where('user_id',Auth::user()->id)->where('employer_id',$user->id)->first()){
                $user->recommended = true; //lai skatā varētu attēlot rekomendācijas statusu (rekomendēts/nerekomendēts)
            }
                
                //ja lietotājam eksistē darba meklētāja dati
            if(Seeker::where('user_id',$id)->first()){
                $seeker = Seeker::where('user_id',$id)->first();

                return View::make("users/view", array('user' => $user,'seeker' => $seeker));
            }else{ //ja lietotājam neeksistē darba meklētāja dati
                return View::make("users/view", array('user' => $user));
            }
        }else{ //ja sistēmā netika atrasts lietotājs ar šādu id
            Session::flash('message-fail',trans('messages.non-existent-user'));
            return Redirect::route("users/viewAllUsers");
        }
    }
    
    //visu sistēmā esošo lietotāju apskate
    public function viewAllAction()
    {
        $usersCount = User::all();
        if($usersCount->count()){ //ja sistēmā ir vismaz viens lietotājs
            $users = User::orderBy('created_at','DESC')->paginate(30); //visi lietotāji + "paginate"

            return View::make("users/viewAllUsers", array('users'=> $users));
        }else{ //ja sistēmā nav neviena lietotāja
            return View::make("users/viewAllUsers");
        }
    }
    
    //lietotāja profila rediģēšana
    public function editAction($id)
    {
            //pieejams administratoram un/vai rediģējot paša esošo profilu
        if((Auth::check() && Auth::user()->id==$id) || Auth::user()->userGroup==1)
        {
            if (Input::server("REQUEST_METHOD") == "POST")
            {
                $validator = Validator::make(Input::all(), [
                    "username" => "required|min:3|max:50|alpha_num|unique:users,username,".$id, //ignorē sava ID datus! :)
                    "email" => "required|email|unique:users,email,".$id,
                    "firstname" => "required|alpha|max:70",
                    "lastname" => "required|alpha|max:70",
                    "about" => "max:500",
                    "picture" => "image|max:3000|mimes:jpg,jpeg,png,bmp,gif",
               ]);
                
               if ($validator->passes())
               {   
                   $user = User::find($id);
                   $user->username = Input::get('username');
                   $user->email = Input::get('email');
                   $user->firstname = Input::get('firstname');
                   $user->lastname = Input::get('lastname');
                   $user->about = Input::get('about');
                    
                        //administratoram nav ļauts pašam mainīt savu grupu (tikai citu lietotāju)
                   if (Auth::user()->userGroup==1 && Auth::user()->id!=$id){
                       $prevUserGroup = $user->userGroup;
                       $user->userGroup = Input::get('userGroup');
                   }
                    
                   if(Input::hasfile('picture'))
                   {
                            
                            //vecās bildes lokācija
                        if($user->picture){
                            $oldPic = $user->picture;  
                        }
                            
                        $file = Input::file('picture');
                            
                        $picName = str_random(30).time();
                        $publicPath = public_path('uploads/profileImages/');
                            
                        Image::make($file->getRealPath())->resize(400,null,true)->save($publicPath.$picName.'.'.$file->getClientOriginalExtension());

                        $user->picture = 'uploads/profileImages/'.$picName.'.'.$file->getClientOriginalExtension();
                   }
                       //ja lietotājs tika veiksmīgi saglabāts
                   if($user->save())
                   {
                            //ja tika augšupielādēta jauna bilde, iepriekšējā tiek dzēsta no failu sistēmas
                        if(isset($oldPic)){
                            File::delete(public_path().'\\'.$oldPic);
                        }
                        
                            //ja tika mainīta lietotāja grupa, dzēš nepieciešamos datus (izņemot, ja grupa mainīta no 3->1 un 2->1)
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
                        
                    
                        if(Auth::user()->id==$id){ //ja lietotājs rediģējis pats savus profila datus
                            Session::flash('message-success',trans('messages.edited-your-profile'));
                            return Redirect::route("users/profile");
                        }else{  //ja administrators rediģējis cita lietotāja profila datus
                            Session::flash('message-success',trans('messages.edited-profile',['user' => $user->username]));
                            return Redirect::to("/viewUser/{$id}");
                        }
                    }
                }
                    //ievades kļūmju gadījumā
                $data["errors"] = $validator->errors();
                Session::flash('message-fail',trans('messages.couldnt-edit-userdata'));
                return Redirect::to("/editUser/{$id}")->withInput(Input::except('picture'))->with($data);
            }
        
            if(User::find($id)){
                $user = User::find($id);
                    //datu izvadei
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
            }else{ //neeksistējoša lietotāja gadījumā
                Session::flash('message-fail',trans('messages.non-existent-user'));
                return Redirect::route("users/viewAllUsers");
            }
            return View::make("/users/edit")->with($data);
    
        }else{ //neatļautas pieejas gadījumā
            Session::flash('message-fail',trans('messages.no-access'));
            return Redirect::route("home");
        }    
        
    }
    
    //lietotāja profila paroles maiņas gadījumā (autorizēts)
    public function changePassAction()
    {   
            //ja lietotājs ir pierakstījies
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
                        
                        //pārbauda esošās paroles pareizību
                    if(Hash::check($old_password,$user->getAuthPassword())){
                        $user->password = Hash::make($password);
                                
                            //saglabā lietotāju citu (jauno) paroli
                        if($user->save()){
                            Session::flash('message-success',trans('message.password-changed-authuser'));
                            return Redirect::route("users/profile");                                
                        }
                    }else{ //nekorektas esošās paroles ievades gadījumā
                        $data["errors"] = new MessageBag([
                            "password" => [trans('messages.wrong-current-password')],
                        ]);
                            
                        Session::flash('message-fail',trans('messages.couldnt-change-pass'));
                        return Redirect::route("users/changePass")->with($data);
                    }
                }
                    //nekorektu ievades datu gadījumā
                $data["errors"] = $validator->errors();
                Session::flash('message-fail',trans('messages.couldnt-change-pass'));
                return Redirect::route("users/changePass")->with($data);
            }
            return View::make("users/changePass"); 
        }
        
            //neautorizēta lietotāja gadījumā (normālos apstākļos nav sasniedzams)
        Session::flash('message-fail',trans('messages.not-logged-in'));
        return Redirect::route("users/login");
    }
    
    //lietotāja profila apskate
    public function profileAction()
    {   
            //ja lietotājs ir pierakstījies
        if(Auth::check()){
            return View::make("users/profile");
        }
        
            //neautorizēta lietotāja gadījumā (normālos apstākļos nav sasniedzams)
        Session::flash('message-fail',trans('messages.not-logged-in'));
        return Redirect::route("users/login");
    }
    
    //lietotāja izrakstīšanās no sistēmas
    public function logoutAction()
    {
        Auth::logout(); //lietotājs tiek izrakstīts
        $lastLang = Session::get('locale');
        Session::flush();
            //valoda tiek saglabāta sesijas "cepumā"
            //lai pēc izrakstīšanās nemainītos uzstādītā valoda
        Session::put('locale',$lastLang);
        
        Session::flash('message-success',trans('messages.logged-out'));
        return Redirect::route("home");
    }
    
    //lietotāja profila dzēšana
    public function deleteAction($id)
    {
            //pieejama pašam lietotājam un administratoriem
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
                    
                        //ja lietotāja paroles apstiprinājums sakrīt ar esošo paroli
                    if(Hash::check($password,Auth::user()->getAuthPassword())){
                            
                        //nepieciešams dzēst lietotāja atstātos datus (vakanču gadījumā nepieciešams dzēst arī piesaistītos pieteikumus)
                        //netraucē arī darba meklētāju lietotāju tipam
                        $recommendations = Recommendation::where('employer_id',$id);
                        $recommendations->delete(); 
                        $myRecommendations = Recommendation::where('user_id',$id);
                        $myRecommendations->delete(); 
                        $applications = Application::where('user_id',$id);
                        $applications->delete(); 
                        $seekers = Seeker::where('user_id',$id);
                        $seekers->delete();
                        $messages = Message::where('sender_id',$id)->orWhere('receiver_id',$id);
                        $messages->delete();
                            
                        $vacancies = Vacancie::where('creator_id',$id)->get(); //savas vakances
                        foreach($vacancies as $vacancie){
                            $eachApp = Application::where('vacancie_id',$vacancie->id);
                            $eachApp->delete();
                        }
                        $allVacs = Vacancie::where('creator_id',$id);
                        $allVacs->delete();
                                           
                            //veiksmīgas profila dzēšanas gadījumā
                        if($user->delete()){
                                    
                                //dzēš lietotāja bildi no failu sistēmas
                            if($user->picture){
                            File::delete(public_path().'\\'.$user->picture);
                             }
                                
                             Session::flash('message-success',trans('messages.deleted-profile',['user' => $user->username]));
                             return Redirect::route("home");                                
                        }
                                
                    }else{ //nepareiza lietotāja paroles apstiprinājuma gadījumā
                        $data["errors"] = new MessageBag([
                            "password" => [trans('messages.wrong-password')],
                        ]);
                            
                        Session::flash('message-fail',trans('messages.couldnt-delete-profile'));
                        return Redirect::to("/deleteUser/{$id}")->with($data);
                    }
                }
                
                    //nekorektu ievades datu gadījumā
                $data["errors"] = $validator->errors();
                Session::flash('message-fail',trans('messages.couldnt-delete-profile'));
                return Redirect::to("/deleteUser/{$id}")->with($data); 
            }
                
                //ja lietotājs ar šādu id tiek atrasts sistēmā
            if(User::find($id)){
                $user = User::find($id);
                    //datu izvadei
                $data["username"] = $user->username;
                $data["userId"] = $user->id;
                return View::make("users/delete")->with($data); 
            }else{ //ja lietotājs ar šādu id nav atrasts sistēmā
                Session::flash('message-fail',trans('messages.non-existent-user'));
                return Redirect::route("users/viewAllUsers");
            }  
            
        }else{ //ja lietotājam nav pieeja šai funkcijai
            Session::flash('message-fail',trans('messages.no-access'));
            return Redirect::route("home");
        }   
    }
    
}