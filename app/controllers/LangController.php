<?php

class LangController extends BaseController {
        
    public function changeLang($lang)
    {        
        if(Config::get('app.locale')==$lang)
        {
            if(Auth::check() && Auth::user()->prefLang!=$lang){
                $user = User::find(Auth::user()->id);
                $user->prefLang=$lang;
                $user->save();
                
                Session::flash('message','Vēlamā valoda samainīta uz '.$lang);
                Session::flash('alert-class','alert-success');
                return Redirect::route("home");
            }
            
            Session::flash('message','Valoda jau ir '.$lang);
            return Redirect::route("home");
        }
        
        if(in_array($lang,Config::get('app.languages')))
        {
            if(Auth::check()){
                $user = User::find(Auth::user()->id);
                $user->prefLang=$lang;
                $user->save();
            }
            
            Session::put('locale', $lang);
            Session::flash('message','Veiksmīgi samainīta valoda uz '.$lang);
            Session::flash('alert-class','alert-success');
            return Redirect::route("home");
        }else{ //ja nu tomēr kādam izdodas tikt līdz šejienei
            Session::flash('message','Neeksistējoša valoda '.$lang);
            Session::flash('alert-class','alert-fail');
            return Redirect::route("home");
        }
    }
}