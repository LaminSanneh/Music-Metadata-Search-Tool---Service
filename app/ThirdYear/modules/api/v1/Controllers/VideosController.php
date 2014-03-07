<?php
namespace Thirdyear\Modules\Api\V1\Controllers;
use \Artist as Artist;
use \Album as Album;
use \Song as Song;
use \ThirdYear\Models\Video as Video;
use Illuminate\Support\Facades\Redirect;
use \View as View;
use \Input as Input;
use \Response as Response;
use \Guzzle\Http\Client as Client;
class VideosController extends \BaseController {

    public $base_url = 'https://www.googleapis.com/youtube/v3';
    public $api_key = 'AIzaSyCVw7HdVZxCU7wj-aEqnBaCSgchsHI22Zc';

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $name = Input::get('name');
        if(isset($name)){
            $search_url = "search?part=snippet&q={$name}&order=relevance&type=video&videoDefinition=high&videoEmbeddable=true&key={$this->api_key}";
            $client = new Client($this->base_url);
            $request = $client->get($search_url);
            $response = $request->send();
            $videos = $response->json();
//            dd($videos);
            $video_items = $videos["items"];


            $formatted_response = array();
            foreach($video_items as $video_item){
                $video = new Video;
                $video->url = "https://www.youtube.com/watch?v=".$video_item["id"]["videoId"];
                $video->name = $video_item["snippet"]["title"];
                $video->picture= $video_item["snippet"]["thumbnails"]["high"]["url"];
                $video->type= "youtube";
                $video->id = $video_item["id"]["videoId"];

//                if(!Video::where("url", $video->url)->count() > 0){
//
//                }

                array_push($formatted_response, $video->toArray());
            }
            return Response::json(array('videos' => $formatted_response),200);
        }
        else{
            return Response::json(array('message' => 'bad request, you must pass a name valid key in query string'), 404);
        }
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return View::make('videos.create');
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
        return View::make('videos.show');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        return View::make('videos.edit');
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
