<?php

use Illuminate\Routing\Redirector;

class MessagingController extends BaseController {
    
    //administratora kontaktēšana izmantojot e-pastu
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
                    //ja atrod kaut vienu administratoru ar aktīvu profilu
                if(User::where('userGroup',1)->where('active',1)->first())
                {
                        //nejauši izvēlas kādu no administratoriem
                    $randomAdmin = User::where('userGroup',1)->where('active',1)->orderBy(DB::raw('RAND()'))->first();

                    Mail::send('emails.contact', array('username'=>Input::get("username"),'messageText'=>Input::get("message"),'email'=>Input::get("email")), function($message) use ($randomAdmin) {
                        $message->from("sender@yopmail.com", "sender"); // no
                        $message->to($randomAdmin->email,$randomAdmin->username)->subject(Input::get("subject"));
                    });
                
                    Session::flash('message-success',trans('messages.email-sent-to-admin',['admin' => $randomAdmin->username]));
                    return Redirect::route("home");
                }else{
                        //ja nav neviena aktīva reģistrēta administratora
                    Session::flash('message-fail',trans('messages.no-admins'));
                    return Redirect::route("home");
                }
            }
        
            $data["errors"] = $validator->errors();
            Session::flash('message-fail',trans('messages.email-notSent-to-admin'));
            return Redirect::route("messaging/contact")->withInput(Input::all())->with($data); 
        }
        
            //ja lietotājs pierakstījies - automātiski aizpilda dažus laukus
        if(Auth::check()){
            $data["username"] = Auth::user()->username;
            $data["email"] = Auth::user()->email;
        }else{ 
            //lai dati tiktu iestatīti
            $data["username"] = "";
            $data["email"] = ""; 
        }  
        
        return View::make("messaging/contact")->with($data);
    }
    
    //privātās ziņas nosūtīšana
    public function sendAction($receiver_id)
    {
            //ja neeksistē lietotājs, kuram tiek mēģināts sūtīt ziņu
        if(!User::find($receiver_id))
        {
            Session::flash('message-fail',trans('non existent user'));
            return Redirect::route("home");
        }
        
        if (Input::server("REQUEST_METHOD") == "POST")
        {
            $validator = Validator::make(Input::all(), [
                "subject" => "required|min:3|max:100",
                "message" => "required|min:3|max:1000",
            ]);
                    
            if ($validator->passes())
            {   
                $message = new Message;
                $message->subject = Input::get('subject');                  
                $message->message = Input::get('message');
                $message->sender_id = Auth::user()->id;
                $message->receiver_id = $receiver_id;
                         
                    //ziņa tiek saglabāta (nosūtīta)
                if($message->save())
                {
                    Session::flash('message-success',trans('message sent'));
                    return Redirect::to("/viewMessage/{$message->id}");
                }
            }
            
                //pieteikuma kļūmju gadījumā
            $data["errors"] = $validator->errors();
            Session::flash('message-fail',trans('sending message failed'));
            return Redirect::to("/sendMessage/{$receiver_id}")->withInput(Input::all())->with($data);
        }
        
        $user = User::find($receiver_id);
            //datu izvadei
        $data["receiver_id"] = $receiver_id;
        $data["username"] = $user->username;
        return View::make("messaging/send")->with($data);
    }
    
    //ziņas dzēšana no sistēmas (tikai administratoriem)
    public function deleteAction($message_id)
    {
            //ja neeksistē ziņa, kuru tiek mēģināts izdzēst
        if(!Message::find($message_id))
        {
            Session::flash('message-fail',trans('non existent message'));
            return Redirect::to("viewMessages/".Auth::user()->id);
        }
        
        $message = Message::find($message_id);
            //ja veiksmīgi tiek dzēsta ziņa
        if($message->delete())
        {
            Session::flash('message-success',trans('message deleted successfully',['subject' => $message->subject]));
            return Redirect::back();                               
        }else{
                //ja kāda nezināma iemesla dēļ netiek izdzēsta ziņa
            Session::flash('message-fail',trans('could not delete message'));
            return Redirect::to("viewMessages/".$message->sender_id);  
        }
    }
    
    //skatīt lietotāja saņemtās un nosūtītās ziņas
    public function viewMessagesAction($user_id)
    {   
            //drīkst skatīt tikai administrators vai pats
        if (Auth::check() && (Auth::user()->userGroup == 1 || Auth::user()->id == $user_id))
        {       
                //visas ziņas + paginācija
            $messages = Message::where('sender_id',$user_id)->orWhere('receiver_id',$user_id)->orderBy('created_at','DESC')->paginate(20);
            $messages->receivedCount = Message::where('receiver_id',$user_id)->count();
            $messages->sentCount = Message::where('sender_id',$user_id)->count();
            $data["user_id"] = $user_id;
            $data["username"] = User::find($user_id)->username;
                
                    //uzzin, vai katra no ziņām ir saņemta vai nosūtīta
                foreach ($messages as $message){
                    if ($message->sender_id == $user_id){
                        $message->sent = true;
                        $message->sentTo = User::find($message->receiver_id)->username;
                    }else if ($message->receiver_id == $user_id){
                        $message->received = true;
                        $message->receivedFrom = User::find($message->sender_id)->username;
                        
                        if ($user_id == Auth::user()->id && $message->viewed != 1){
                            $message->new = true;
                        }
                    }
                }
            
            if ($messages->sentCount == 0 && $messages->receivedCount == 0){
                return View::make("messaging/viewMessages")->with($data);
            }else{
                return View::make("messaging/viewMessages", array('messages' => $messages))->with($data);
            }
        }
            
            //neatļautas pieejas gadījumā, pārvirza uz savām ziņām
        Session::flash('message-fail',trans('no access'));    
        return Redirect::to("viewMessages/".Auth::user()->id); 
    }
    
}