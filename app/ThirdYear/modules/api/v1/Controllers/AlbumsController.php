<?php
namespace Thirdyear\Modules\Api\V1\Controllers;
use \Artist as Artist;
use \Album as Album;
use \Song as Song;
use Illuminate\Support\Facades\Redirect;
use \View as View;
use \Input as Input;
use \Response as Response;
use ThirdYear\Services\Album\AlbumServiceInterface;
class AlbumsController extends \BaseController {

    public $albumService;

    public function __construct(AlbumServiceInterface $albumService){
        $this->albumService = $albumService;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $name = Input::get('name');
//        dd($name);
        $albums = $this->albumService->getAlbumsByName($name);

        $albums = array_map(function($album){
            $artist_id = $album["artist"]["id"];
            $album["artist"] = $artist_id;
            return $album;
        }, $albums);

        return Response::json(compact('albums'),200);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return View::make('albums.create');
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
        $album = $this->albumService->getAlbumById($id);

//        dd($album);
//        Format for ember data
        $data["songs"] = array_map(function($song){
            return array(
                'id' => $song["id"],
                'name' => $song["name"],
                'album' => $song["album_id"],
            );
        },$album["songs"]);


        $album["artist"] = $album["artist"]["id"];
        $album["songs"] = array_map(function($song){
            return $song["id"];
        },$album["songs"]);

        $data["album"] = $album;

//        dd($data);

        return Response::json($data,200);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        return View::make('albums.edit');
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
