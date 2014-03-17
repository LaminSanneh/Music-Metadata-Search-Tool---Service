<?php
namespace Thirdyear\Modules\Api\V1\Controllers;
use \Artist as Artist;
use \Album as Album;
use \Song as Song;
use Illuminate\Support\Facades\Redirect;
use ThirdYear\Services\Song\SongServiceInterface;
use \View as View;
use \Input as Input;
use \Response as Response;
use League\Fractal\Manager as FractalManager;
use \League\Fractal\Resource\Item as FractalItem;
use \League\Fractal\Resource\Collection as FractalCollection;
class SongsController extends \BaseController {

    public function __construct(SongServiceInterface $songService){
        $this->songService = $songService;
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
        $songs = $this->songService->getSongsByName($name);
        return Response::json(compact('songs'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return View::make('songs.create');
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
        return View::make('songs.show');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        return View::make('songs.edit');
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
