<?php

class BaseController extends Controller {
    
    public function __construct(){
        
        //paziņojumu functionalitāte, kas nepieciešama vienīgi administratoriem un darba devējiem
        if(Auth::check() && Auth::user()->userGroup!=3){
            
            $userVacancies = Vacancie::where('creator_id',Auth::user()->id)->get();
            $count = 0;
            
            foreach($userVacancies as $userVacancie){
                $count = $count + Application::where('viewed','<>',1)->where('vacancie_id',$userVacancie->id)->count();
            }
            
            if($count>0) {
                    //lai darba devējam izvēlnē attēlotu nesen pietiekušos darba meklētājus 
                View::share('newApplicants',$count);
            }
        }
    }
    
    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    
    protected function setupLayout()
    {
	if ( ! is_null($this->layout))
	{
            $this->layout = View::make($this->layout);
	}
    }

}