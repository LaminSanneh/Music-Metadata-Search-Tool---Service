<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function index()
	{
        $service = new \Discogs\Service();
        $resultset = $service->search(array(
            'q'     => 'The Beatles',
//            'artist' => 'Jay Z'
            'type' => 'artist'
        ));
        echo count($resultset)."\n";
//        print_r($resultset);

        $artist = $service->getArtist(38661);
        print_r($artist);
	}

}