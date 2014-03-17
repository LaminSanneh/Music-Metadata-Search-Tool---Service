<?php
namespace ThirdYear\Services\Album;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use ThirdYear\Services\Artist\ArtistServiceInterface;
use \Response as Response;
use \Guzzle\Http\Client as Client;
use \Artist as Artist;
use \Album as Album;
use \Song as Song;
class FreebaseAlbumService implements AlbumServiceInterface{

    public $base_url = 'https://www.googleapis.com/freebase/v1sandbox';
    public $api_key = 'AIzaSyCVw7HdVZxCU7wj-aEqnBaCSgchsHI22Zc';
    public $image_url_prefix = "https://usercontent.googleapis.com/freebase/v1/image";
    public $client;

    public function __construct(){
        $this->client = new Client($this->base_url);
    }

    public function getAlbumsByName($name, $limit = null, $language = 'en')
    {
        $query = array(
            'query' => $name,
            'limit' => $limit!==null ? $limit : 10,
            'key' => $this->api_key,
            'lang' => $language,
            'type' => '/music/album',
            'output' => '(/common/topic/description /common/topic/image /music/album/artist)'
        );

        $search_url = "search?".http_build_query($query);
        $request = $this->client->get($search_url);
        $response = $request->send();
        $albums = $response->json();
        $album_items = $albums["result"];

//        dd($album_items);

        $formatted_response = array();
        foreach($album_items as $album_item){
//            if(isset($album_item["output"]["/common/topic/image"]["/common/topic/image"][0]["mid"])){
                if(!$this->albumExistsInDb($album_item)){
                    $album = new Album();

                    if(isset($album_item["output"]["/common/topic/image"]["/common/topic/image"][0]["mid"])){
                        $image_id = $album_item["output"]["/common/topic/image"]["/common/topic/image"][0]["mid"];
                        $album->picture = $this->image_url_prefix."/".$image_id.'?maxwidth=225&maxheight=225&mode=fillcropmid';
                    }
                    else{
                        $album->picture = '';
                    }

                    $album->service_id = $album_item["mid"];
                    $album->name = $album_item["name"];
                    $description = $album_item["output"]["/common/topic/description"];

                    if(isset($album_item["output"]["/common/topic/description"]["/common/topic/description"])){
                        $album->notes = $album_item["output"]["/common/topic/description"]["/common/topic/description"][0];
                    }
                    else{
                        $album->notes = "";
                    }

                    $artist =
                        $this->createNewArtistOrGetExistingOne($album_item["output"]["/music/album/artist"]["/music/album/artist"][0]);

                    //                dd($artist);
                    $artist->albums()->save($album);
                    $album->load('artist');

                }
                else{
                    $album = Album::with('artist')->where('service_id', $album_item["mid"])->first();
                }
                array_push($formatted_response, $album->toArray());
//            }
        }

        return $formatted_response;
    }

    private function saveArtistsNotInDb($artists){
        //Get the keys for all artists
        $service_ids = array_map(function($artist){
            return $artist->service_id;
        }, $artists);

        //Get the service ids for artists who already exist in database
        $artistsInDb = Artist::whereIn('service_id', $service_ids)->lists('service_id');


        //Filter all artists and get the one who are not in the database
        $artistsNotInDb = array_filter($artists, function($artist) use($artistsInDb){
            return !in_array($artist->service_id, $artistsInDb);
        });

        //Save the artists who are not in the database
        foreach($artistsNotInDb as $artistNotInDb){
            $artistNotInDb->save();
        }

        return $artistsNotInDb;
    }

    private function getExistingArtistsFromDatabase($artists){
        //Get the keys for all artists
        $service_ids = array_map(function($artist){
            return $artist->service_id;
        }, $artists);

        //Refresh artists who already exist in database
        $artistsInDb = Artist::whereIn('service_id', $service_ids)->get();

        return $artistsInDb;
    }


    /**
     * @param $id
     * @return array|null
     */
    public function getAlbumById($id)
    {
        $album = Album::find($id);

        $mid = $album->service_id;

        $key = $this->api_key;
        $query = array(
            "mid" => $mid,
            "output" => "(/common/topic/description /common/topic/image (/music/album/releases /music/release/track_list) /music/album/artist)",
            "key" => $this->api_key
        );

        $search_url = "search?".http_build_query($query);
        $request = $this->client->get($search_url);
        $response = $request->send();
        $albums = $response->json();
        $album_items = $albums["result"];

        if(count($album_items) > 0){
            $required_album = $album_items[0];
//            dd($required_album);
            //Update artists details with fresh data from freebase webservice
            if($album){
                $description = $required_album["output"]["/common/topic/description"];

                if(isset($description["/common/topic/description"])){
                    $album->notes = $description["/common/topic/description"][0];
                }

                if(isset($required_album["output"]["/common/topic/image"]["/common/topic/image"][0]["mid"])){
                    $image_id = $required_album["output"]["/common/topic/image"]["/common/topic/image"][0]["mid"];
                    $album->picture = $this->image_url_prefix."/".$image_id.'?maxwidth=225&maxheight=225&mode=fillcropmid';
                }

                $album->save();

                if(isset($required_album["output"]["/music/album/artist"]["/music/album/artist"][0])){
                    $album_artist = $required_album["output"]["/music/album/artist"]["/music/album/artist"][0];

                    if($this->artistExistsInDb($album_artist)){
                        $artist = Artist::where('service_id', $album_artist["mid"])->first();
                        $album->artist()->associate($artist);
                        $album->save();
                    }
                    else{
                        $artist = new Artist();
                        $artist->name = $album_artist["name"];
                        $artist->service_id= $album_artist["mid"];
                        $artist->real_name = "";
                        $artist->profile = "";
                        $artist->picture = "";
                        $artist->save();

                        $album->artist()->associate($artist);
                    }
                }
                else{
//                $album->artist = null;
                }

//                dd($required_album);
                if(isset($required_album["output"]["/music/album/releases"]["/music/album/releases"][0])){
                    $release = $required_album["output"]["/music/album/releases"]["/music/album/releases"][0];
                    $songs = $release["/music/release/track_list"]["/music/release/track_list"];

                    foreach($songs as $song){
                        if(!$this->songExists($song)){
                            $songForDb = new Song();
                            $songForDb->name = $song["name"];
                            $songForDb->service_id = $song["mid"];
                            $album->songs()->save($songForDb);
                        }
                    }

                    $album->load("songs");
                }
            }
            else{
                throw new NotFoundHttpException("You passed in an id for album that does not exist");
            }

            return $album->toArray();
        }
        else{
            return null;
        }
    }

    private function albumExistsInDb($album){
        return Album::where('service_id', $album["mid"])->count() > 0;
    }

    private function createNewArtistOrGetExistingOne($artist){
        $existingArtist = Artist::where('service_id', $artist["mid"]);
        if($existingArtist->count() > 0){
            //Artist exists in db
            return $existingArtist->first();
        }
        else{
            $newArtist = new Artist;
            $newArtist->name = $artist["name"];
            $newArtist->real_name = "";
            $newArtist->profile = "";
            $newArtist->picture = "";
            $newArtist->service_id = $artist["mid"];
            $newArtist->save();
            return $newArtist;
        }
    }

    private function artistExistsInDb($artist){
        return Artist::where('service_id', $artist["mid"])->count() > 0;
    }

    private function songExists($song){
        return Song::where('service_id', $song["mid"])->count() > 0;
    }
}

?>