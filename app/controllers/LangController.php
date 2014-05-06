<?php

use Illuminate\Routing\Redirector;

class LangController extends BaseController {
        
    public function changeLang($lang)
    {        
        if(Config::get('app.locale')==$lang)
        {
            if(Auth::check() && Auth::user()->prefLang!=$lang){
                $user = User::find(Auth::user()->id);
                $user->prefLang=$lang;
                $user->save();
                
                Session::flash('message-success','Preferred user language changed to '.$lang);
                return Redirect::back();
            }
            
            Session::flash('message-info','Language already is '.$lang);
            return Redirect::back();
        }
        
        if(in_array($lang,Config::get('app.languages')))
        {
            if(Auth::check()){
                $user = User::find(Auth::user()->id);
                $user->prefLang=$lang;
                $user->save();
            }
            
            Session::put('locale', $lang);
            Session::flash('message-success','Successfully changed language to '.$lang);
            return Redirect::back();
            
        }else{ //ja nu tomēr kādam izdodas tikt līdz šejienei
            Session::flash('message-fail','Non existent language - '.$lang);
            return Redirect::back();
        }
    }
}