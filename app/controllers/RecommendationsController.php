<?php

use Illuminate\Routing\Redirector;

class RecommendationsController extends BaseController {
    
    public function RecommendAction($userId)
    {
        
        if (Auth::check() && Auth::user()->id == $userId)
        {
            Session::flash('message-fail','Cant recommend yourself, silly');
            return Redirect::back();
        }
        
        if (Auth::check() && Recommendation::where('user_id',Auth::user()->id)->where('employer_id',$userId)->first())
        {
            Session::flash('message-info','Already recommended this employer');
            return Redirect::back();
        }
        
        
        if(Auth::check() && !Recommendation::where('user_id',Auth::user()->id)->where('employer_id',$userId)->first())
        {
        
            $recommendation = new Recommendation;
            $recommendation->user_id = Auth::user()->id;
            $recommendation->employer_id = $userId;
            
                if($recommendation->save())
                {
                Session::flash('message-success','Darba devējs ir rekomendēts');
                return Redirect::back();
                }
            Session::flash('message-fail','Nevarēja rekomendēt darba devēju');
            return Redirect::back();
        
        }
        Session::flash('message-fail','No access to action');
        return Redirect::back();
    }
    
}