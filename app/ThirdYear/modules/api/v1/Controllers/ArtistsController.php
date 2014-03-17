<?php

namespace Thirdyear\Modules\Api\V1\Controllers;

use \Artist as Artist;
use \Album as Album;
use \Song as Song;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use ThirdYear\Services\Artist\ArtistServiceInterface;
use ThirdYear\Services\Transformers\ArtistTransformer;
use \View as View;
use \Input as Input;
use \Response as Response;
use League\Fractal\Manager as FractalManager;
use \League\Fractal\Resource\Item as FractalItem;
use \League\Fractal\Resource\Collection as FractalCollection;

class ArtistsController extends \BaseController {

    public $artistService;
    public $fractal;

    public function __construct(ArtistServiceInterface $artistService){
        $this->artistService = $artistService;
        $this->fractal = new FractalManager();
        if(isset($_GET['embed'])){
            $this->fractal->setRequestedScopes(explode(',',$_GET['embed']));
        }
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $name = Input::get('name');
        if(!$name){
            return Response::json(null, 400, array("reason" => "You must pass a 'name' query string"));
        }
        $artists = $this->artistService->getArtistsByName($name);

//        Fractals
//        $fractalCollection = new FractalCollection($artists, new ArtistTransformer());
//        $data = $this->fractal->createData($fractalCollection)->toArray();
//        return Response::json(array('artists' => $data["data"]),200);

        return Response::json(array('artists' => $artists),200);

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
            $artist = $this->artistService->getArtistByID($id);

//            $fractalItem = new FractalItem($artist, new ArtistTransformer());
//            $data = $this->fractal->createData($fractalItem)->toArray();
//            return Response::json(array('artist' => $data["data"]),200);

//        Sideload data for ember data
        $albums = $artist["albums"];
        $artist["albums"] = array_map(function($album){
            return $album["id"];
        },$albums);

//        Get Artist attribues except the albums
        $artist = array(
            'id' => $artist["id"],
            'name' => $artist["name"],
            'real_name' => $artist["real_name"],
            'service_id' => $artist["service_id"],
            'albums' => $artist["albums"],
            'profile' => $artist["profile"],
            'picture' => $artist["picture"]
        );

        $emberData = array(
            'artist' => $artist,
            'albums' => $albums
        );

        return Response::json($emberData,200);
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
