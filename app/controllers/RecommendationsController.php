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
    
    //users, who recommended this user
    public function viewRecommendersAction($userId)
    {
        if(!User::find($userId)){
            Session::flash('message-fail','No Employer with such ID');
            return Redirect::route("home");
        }
        
        if(User::find($userId)->userGroup==3){
            Session::flash('message-fail','This user is not an employer');
            return Redirect::route("home");
        }
        
        
        $recCount = Recommendation::where('employer_id',$userId)->count();
        
        if($recCount){
            
            $recommenders = Recommendation::where('employer_id',$userId)->paginate(10);
            $employer = User::find($userId);
            
            foreach($recommenders as $recommender){
            
                $recommender->user = User::find($recommender->user_id);
            }
        
            return View::make("/recommendations/viewRecommenders",array('employer'=>$employer,'recommenders'=>$recommenders));
        }else{
            $employer = User::find($userId);
            return View::make("/recommendations/viewRecommenders",array('employer'=>$employer));
        }
    }
    
    //users, who this user has recommended
    public function viewRecommendationsAction($userId)
    {
        if(!User::find($userId)){
            Session::flash('message-fail','No user with such ID');
            return Redirect::route("home");
        }
        
        $recCount = Recommendation::where('user_id',$userId)->count();
        
        if($recCount){
            
            $recommendations = Recommendation::where('user_id',$userId)->paginate(10);
            $user = User::find($userId);
            
            foreach($recommendations as $recommendation){
            
                $recommendation->user = User::find($recommendation->employer_id);
            }
        
            return View::make("/recommendations/viewRecommendations",array('user'=>$user,'recommendations'=>$recommendations));
        }else{
            $user = User::find($userId);
            return View::make("/recommendations/viewRecommendations",array('user'=>$user));
        }
        
        
        
    }
    
    
}