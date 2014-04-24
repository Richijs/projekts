<?php

use Illuminate\Support\MessageBag;

class ApplicationsController extends BaseController {
    
    public function applyAction($vacancieId)
    {
        //ja neeksistē vakance
        if(!Vacancie::where('id',$vacancieId)->first())
        {
            Session::flash('message-fail','Non existent vacancie');
            return Redirect::route("home");
        }
        
        //ja ir pareiza user grupa
        if((Auth::check() && Auth::user()->userGroup==3) || (Auth::check() && Auth::user()->userGroup==1))
        {        
            //ja nav jau pieteicies šai vakancei
            if (!Application::where('user_id',Auth::user()->id)->where('vacancie_id',$vacancieId)->first())
            {
                //tad viss ok
        
                
                
                
                
                
                
                
                
                
                
                
        
        
            }else{
            Session::flash('message-fail','Already applied this job');
            return Redirect::route("home");
            } 
        
        }else{
        Session::flash('message-fail','No Access to action');
        return Redirect::route("home");
        }    
        
    }
    
    
}