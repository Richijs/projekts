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
                
                Session::flash('message-success',trans('messages.preflang-changed',['lang' => $lang]));
                return Redirect::back();
            }
            
            Session::flash('message-info',trans('messages.lang-already-is',['lang' => $lang]));
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
            Session::flash('message-success',trans('messages.lang-changed',['lang' => $lang]));
            return Redirect::back();
            
        }else{ //ja nu tomēr kādam izdodas tikt līdz šejienei
            Session::flash('message-fail',trans('messages.non-existent-lang',['lang' => $lang]));
            return Redirect::back();
        }
    }
}