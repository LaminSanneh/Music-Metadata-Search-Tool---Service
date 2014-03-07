<?php

namespace Thirdyear\Modules\Api\V1\Controllers;

use \Artist as Artist;
use \Album as Album;
use \Song as Song;
use Illuminate\Support\Facades\Redirect;
use \View as View;
use \Input as Input;
use \Response as Response;
class ArtistsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $name = Input::get('name');
        if(isset($name)){
//            $artists = Artist::where('name','LIKE',"%$name%")->get()->toArray();
            $artists = Artist::whereRaw("MATCH(name) AGAINST(? IN BOOLEAN MODE)", array($name.'*'))->get()->toArray();
        }
        else{
            $artists = Artist::all()->toArray();
        }
        return Response::json(compact('artists'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return View::make('artists.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        return View::make('artists.show');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        return View::make('artists.edit');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
