<?php

class UsersController extends BaseController {
    
    public function viewProfile($id)
    {
        $user = user::find($id);
        if($user) {        
                     
        return View::make('users.profile',array('user' => $user));
        }
        else {return View::make('errors.404');}
    }
}