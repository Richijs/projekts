<?php

class MessagingController extends BaseController {
    
    public function contactAction()
    {
    
        if (Input::server("REQUEST_METHOD") == "POST")
        {
            //aizsardzībai pret esoša username/email izvēlēšanos (atskaitot sava paša)
            if(Auth::check()){
                $id = Auth::user()->id;
            }else{
                $id = null;
            }
                                       
            $validator = Validator::make(Input::all(), [
                "username" => "required|min:3|max:50|alpha_num|unique:users,username,".$id,
                "email" => "required|email|unique:users,email,".$id,
                "subject" => "required|min:3|max:100",
                "message" => "required|min:10|max:1000",
            ]);
                    
            if ($validator->passes())
            {
                if(User::where('userGroup',1)->where('active',1)->first())
                {
                    
                    $randomAdmin = User::where('userGroup',1)->where('active',1)->orderBy(DB::raw('RAND()'))->first();
                    
                                        
                
                    Mail::send('emails.contact', array('username'=>Input::get("username"),'messageText'=>Input::get("message"),'email'=>Input::get("email")), function($message) use ($randomAdmin) {
                        $message->from("sender@yopmail.com", "sender"); // no
                        $message->to($randomAdmin->email,$randomAdmin->username)->subject(Input::get("subject"));
                    });
                
                    Session::flash('message-success','Epasts tika nosūtīts adminstratoram: '.$randomAdmin->username);
                    return Redirect::route("home");
                }else{
                    Session::flash('message-fail','sorry, there are no administrators in the system :(');
                    return Redirect::route("home");
                }
                
            }
        
            $data["errors"] = $validator->errors();
                
            $data["username"] = Input::get("username");
            $data["email"] = Input::get("email");
            $data["subject"] = Input::get("subject");
            $data["message"] = Input::get("message");
            
            Session::flash('message-fail','Sending e-mail to an admin was not successfull');
            return Redirect::route("messaging/contact")->withInput($data)->with($data); 
        }
        
        if(Auth::check()){
            $data["username"] = Auth::user()->username;
            $data["email"] = Auth::user()->email;
            
            return View::make("messaging/contact")->with($data);
        }else{ 
            //so the data is set
            $data["username"] = "";
            $data["email"] = ""; 
            
            return View::make("messaging/contact")->with($data);
        }
    }
    
}