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
        
        if(User::find($userId) && User::find($userId)->userGroup===3){
            
            $username = User::find($userId)->username;
            Session::flash('message-fail',$username.' is not an employer');
            return Redirect::back();
        }
        
        if(!User::find($userId)){
            Session::flash('message-fail','No Such User');
            return Redirect::back();
        }
        
        if (Auth::check() && Recommendation::where('user_id',Auth::user()->id)->where('employer_id',$userId)->first())
        {
            $recommendation = Recommendation::where('user_id',Auth::user()->id)->where('employer_id',$userId);
            $username = User::find($userId)->username;
            
            if($recommendation->delete()){
                Session::flash('message-info','Unrecommended '.$username);
                return Redirect::back();
            }else{
                Session::flash('message-fail','Could not unrecommend '.$username);
                return Redirect::back();
            }
        }
        
        
        if(Auth::check() && !Recommendation::where('user_id',Auth::user()->id)->where('employer_id',$userId)->first())
        {
        
            $recommendation = new Recommendation;
            $recommendation->user_id = Auth::user()->id;
            $recommendation->employer_id = $userId;
            $username = User::find($userId)->username;
            
                if($recommendation->save())
                {
                Session::flash('message-success',$username.' was recommended');
                return Redirect::back();
                }
            Session::flash('message-fail','Could not recommend '.$username);
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
                //cik userim ir recommendo
                $recommendation->userRecommends = Recommendation::where('employer_id',$recommendation->employer_id)->count();
            
                if(Auth::check()){
                    if(Recommendation::where('user_id',Auth::user()->id)->where('employer_id',$recommendation->employer_id)->first()){
                        $recommendation->recommended = true; //lai var displayot (recommend/unrecommend)
                    }
                }
                
            }
        
            return View::make("/recommendations/viewRecommendations",array('user'=>$user,'recommendations'=>$recommendations));
        }else{
            $user = User::find($userId);
            return View::make("/recommendations/viewRecommendations",array('user'=>$user));
        }
        
        
        
    }
    
    
}