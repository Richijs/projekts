<?php

use Illuminate\Routing\Redirector;

class LangController extends BaseController {
        
    //maina vietnes pašreizējo valodu
    public function changeLang($lang)
    {        
            //ja izvēlēta jau uzstādītā valoda
        if(Config::get('app.locale')==$lang)
        {
                //ja lietotāja vēlamā valoda ir bijusi cita
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
        
            //ja tiek izvēlēta kāda no pieejamajām valodām
        if(in_array($lang,Config::get('app.languages')))
        {   
                //ja lietotājs pierakstīts - saglabā viņa vēlamo valodu
            if(Auth::check()){
                $user = User::find(Auth::user()->id);
                $user->prefLang=$lang;
                $user->save();
            }
            
            Session::put('locale', $lang);
            Session::flash('message-success',trans('messages.lang-changed',['lang' => $lang]));
            return Redirect::back();
            
        }else{ //neeksistējošas valodas gadījumā (normālos apstākļos neiespējami)
            Session::flash('message-fail',trans('messages.non-existent-lang',['lang' => $lang]));
            return Redirect::back();
        }
    }
}