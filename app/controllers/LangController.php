<?php

class LangController extends BaseController {
        
    public function changeLang($lang)
    {        
        if(Config::get('app.locale')==$lang)
        {
            Session::flash('message','Valoda jau ir '.$lang);
            return Redirect::route("home");
        }
        
        if(in_array($lang,Config::get('app.languages')))
        {
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