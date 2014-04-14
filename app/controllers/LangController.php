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
            Session::flash('message','Veiksm�gi samainita valoda uz '.$lang);
            Session::flash('alert-class','alert-success');
            return Redirect::route("home");
        }else{
            Session::flash('message','Neeksist�jo�a valoda '.$lang);
            Session::flash('alert-class','alert-fail');
            return Redirect::route("home");
        }
    }
}