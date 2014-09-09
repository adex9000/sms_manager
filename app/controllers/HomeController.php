<?php

class HomeController extends BaseController {

	public function index()
	{
		if(Auth::viaRemember() || Auth::user()){
            return Redirect::to('users/dashboard');
        }
        return View::make('home.index');
	}

}
