<?php

//not yet needed

//use Illuminate\Support\MessageBag;

class HomeController extends BaseController {
        
    public function viewHome()
    {
        return View::make("home");
    }
}