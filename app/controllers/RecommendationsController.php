<?php

use Illuminate\Routing\Redirector;

class RecommendationsController extends BaseController {
    
    //pievieno vai atceļ lietotāja rekomendāciju
    public function recommendAction($userId)
    {
            //ja mēģina rekomendēt pats sevi
        if (Auth::check() && Auth::user()->id == $userId)
        {
            Session::flash('message-fail',trans('messages.cant-recommend-yourself'));
            return Redirect::back();
        }
        
            //nevar rekomendēt lietotāju ar "darba meklētāja" grupu
        if(User::find($userId) && User::find($userId)->userGroup===3){
            
            $username = User::find($userId)->username;
            Session::flash('message-fail',trans('messages.cant-recommend-non-employer',['user' => $username]));
            return Redirect::back();
        }
        
            //ja šāds lietotājs neeksistē
        if(!User::find($userId)){
            Session::flash('message-fail',trans('messages.no-such-user'));
            return Redirect::back();
        }
        
            //ja lietotājs jau ticis rekomendēts - atceļ rekomendāciju
        if (Auth::check() && Recommendation::where('user_id',Auth::user()->id)->where('employer_id',$userId)->first())
        {
            $recommendation = Recommendation::where('user_id',Auth::user()->id)->where('employer_id',$userId);
            $username = User::find($userId)->username;
            
                //dzēš rekomendāciju
            if($recommendation->delete()){
                Session::flash('message-info',trans('messages.unrecommended',['user' => $username]));
                return Redirect::back();
            }
            
                //ja neizdodas dzēst rekomendāciju
            Session::flash('message-fail',trans('messages.couldnt-unrecommend',['user' => $username]));
            return Redirect::back();
        }
        
            //ja lietotājs nav jau ticis rekomendēts
        if(Auth::check() && !Recommendation::where('user_id',Auth::user()->id)->where('employer_id',$userId)->first())
        {
            $recommendation = new Recommendation;
            $recommendation->user_id = Auth::user()->id;
            $recommendation->employer_id = $userId;
            $username = User::find($userId)->username;
                
                    //pievieno jaunu rekomendāciju
            if($recommendation->save())
            {
                Session::flash('message-success',trans('messages.recommended',['user' => $username]));
                return Redirect::back();
            }
                
                //ja neizdodas pievienot rekomendāciju
            Session::flash('message-fail',trans('messages.couldnt-recommend',['user' => $username]));
            return Redirect::back();
        }
            //ja nav attiecīgā pieeja
        Session::flash('message-fail',trans('messages.no-access'));
        return Redirect::back();
    }
    
    //skatīt lietotājus, kas rekomendējuši šo darba devēju
    public function viewRecommendersAction($userId)
    {
            //ja netiek atrasts šāds lietotājs
        if(!User::find($userId)){
            Session::flash('message-fail',trans('messages.non-existent-employer'));
            return Redirect::route("home");
        }
            //ja lietotājs tiek atrasts, taču nav darba devējs/administrators
        if(User::find($userId)->userGroup==3){
            Session::flash('message-fail',trans('messages.not-an-employer'));
            return Redirect::route("home");
        }
        
        $recCount = Recommendation::where('employer_id',$userId)->count();
        
        if($recCount){
            
            $recommenders = Recommendation::where('employer_id',$userId)->orderBy('created_at','DESC')->paginate(30);
            $employer = User::find($userId);
            
            foreach($recommenders as $recommender){
                $recommender->user = User::find($recommender->user_id);
            }
        
            return View::make("/recommendations/viewRecommenders",array('employer'=>$employer,'recommenders'=>$recommenders));
        }else{
                //ja šim lietotājam nav neviena rekomendētāja
            $employer = User::find($userId);
            return View::make("/recommendations/viewRecommenders",array('employer'=>$employer));
        }
    }
    
    //skatīt lietotājus, kurus šis lietotājs ir rekomendējis
    public function viewRecommendationsAction($userId)
    {
            //ja neeksistē šāds lietotājs
        if(!User::find($userId)){
            Session::flash('message-fail',trans('messages.non-existent-user'));
            return Redirect::route("home");
        }
        
        $recCount = Recommendation::where('user_id',$userId)->count();
        
        if($recCount){
            
            $recommendations = Recommendation::where('user_id',$userId)->orderBy('created_at','DESC')->paginate(30);
            $user = User::find($userId);
            
            foreach($recommendations as $recommendation){
            
                $recommendation->user = User::find($recommendation->employer_id);
                
                    //cik katram lietotājam ir rekomendāciju
                $recommendation->userRecommends = Recommendation::where('employer_id',$recommendation->employer_id)->count();
            
                if(Auth::check()){
                    if(Recommendation::where('user_id',Auth::user()->id)->where('employer_id',$recommendation->employer_id)->first()){
                        $recommendation->recommended = true; //lai skatā varētu noteikt rekomendāciju statusu
                    }
                }
            }
        
            return View::make("/recommendations/viewRecommendations",array('user'=>$user,'recommendations'=>$recommendations));
        }else{
                //ja lietotājs nevienu nav rekomendējis
            $user = User::find($userId);
            return View::make("/recommendations/viewRecommendations",array('user'=>$user));
        }
    }
    
    
}