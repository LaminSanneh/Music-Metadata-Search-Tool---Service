<?php
namespace ThirdYear\Services\Song;

use ThirdYear\Services\Song\SongServiceInterface;
use \Response as Response;
use \Guzzle\Http\Client as Client;
use \Artist as Artist;
use \Album as Album;
use \Song as Song;
class FreebaseSongService implements SongServiceInterface{

    public $base_url = 'https://www.googleapis.com/freebase/v1sandbox';
    public $api_key = 'AIzaSyCVw7HdVZxCU7wj-aEqnBaCSgchsHI22Zc';
    public $image_url_prefix = "https://usercontent.googleapis.com/freebase/v1/image";
    public $client;

    public function __construct(){
        $this->client = new Client($this->base_url);
    }

    public function getArtistsByName($name, $limit = null, $language = 'en')
    {
        $query = array(
            'query' => $name,
            'limit' => $limit!==null ? $limit : 10,
            'key' => $this->api_key,
            'lang' => $language,
            'type' => '/music/artist',
            'output' => '(/common/topic/description /common/topic/image)'
        );

        $search_url = "search?".http_build_query($query);
        $request = $this->client->get($search_url);
        $response = $request->send();
        $artists = $response->json();
        $artist_items = $artists["result"];

//        dd($artists);

        $formatted_response = array();
        foreach($artist_items as $artist_item){

            if($this->artistExistsInDb($artist_item)){
                $artist = $this->getArtistByMID($artist_item["mid"]);

                $description = $artist_item["output"]["/common/topic/description"];
                $artist->service_id = $artist_item["mid"];
                if(isset($description["/common/topic/description"])){
                    $artist->profile = $description["/common/topic/description"][0];
                }

                if(isset($artist_item["output"]["/common/topic/image"]["/common/topic/image"][0]["mid"])){
                    $image_id = $artist_item["output"]["/common/topic/image"]["/common/topic/image"][0]["mid"];
                    $artist->picture = $this->image_url_prefix."/".$image_id.'?maxwidth=225&maxheight=225&mode=fillcropmid';
                }
            }
            else{
                $artist = new Artist;
                $artist->name = $artist_item["name"];
                $artist->real_name = "";
                $description = $artist_item["output"]["/common/topic/description"];
                $artist->service_id = $artist_item["mid"];
                if(isset($description["/common/topic/description"])){
                    $artist->profile = $description["/common/topic/description"][0];
                }
                else{
                    $artist->profile = "";
                }

                if(isset($artist_item["output"]["/common/topic/image"]["/common/topic/image"][0]["mid"])){
                    $image_id = $artist_item["output"]["/common/topic/image"]["/common/topic/image"][0]["mid"];
                    $artist->picture = $this->image_url_prefix."/".$image_id.'?maxwidth=225&maxheight=225&mode=fillcropmid';
                }
                else{
                    $artist->picture = "";
                }
            }

            $artist->save();
            array_push($formatted_response, $artist->toArray());
        }

//        $artistsNotInDb = $this->saveArtistsNotInDb($formatted_response);
//        $artistsInDb = $this->getExistingArtistsFromDatabase($formatted_response);
//
//
//        //If results are not empty, convert to array
//        $artistsNotInDb = count($artistsNotInDb) == 0 ? [] : $artistsNotInDb;
//        $artistsInDb = count($artistsInDb) == 0 ? [] : $artistsInDb;

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
        $artistsInDb = Artist::whereIn('service_id', $service_ids)->get()->toArray();

        return $artistsInDb;
    }


    /**
     * @param $mid
     * Mid Stands for Machine Identifier
     * @return array|null
     */
    public function getArtistByID($id)
    {
        $artist = Artist::find($id);

        $mid = $artist->service_id;

        $key = $this->api_key;
        $query = array(
            "mid" => $mid,
            "output" => "(/common/topic/description /common/topic/image (/music/artist/album /common/topic/image /common/topic/description))",
            "key" => $this->api_key
        );

        $search_url = "search?".http_build_query($query);
        $request = $this->client->get($search_url);
        $response = $request->send();
        $artists = $response->json();
        $artist_items = $artists["result"];

        if(count($artist_items) > 0){
            $required_artist = $artist_items[0];

            //Update artists details with fresh data from freebase webservice
            if($artist){
                $description = $required_artist["output"]["/common/topic/description"];

                if(isset($description["/common/topic/description"])){
                    $artist->profile = $description["/common/topic/description"][0];
                }

                if(isset($required_artist["output"]["/common/topic/image"]["/common/topic/image"][0]["mid"])){
                    $image_id = $required_artist["output"]["/common/topic/image"]["/common/topic/image"][0]["mid"];
                    $artist->picture = $this->image_url_prefix."/".$image_id.'?maxwidth=225&maxheight=225&mode=fillcropmid';
                }

                $artist->save();
            }

            $artist_albums = array();

            if(isset($required_artist["output"]["/music/artist/album"]["/music/artist/album"])){
                $albums = $required_artist["output"]["/music/artist/album"]["/music/artist/album"];

                foreach($albums as $album){
                    if(isset($album["/common/topic/image"]["/common/topic/image"]) &&
                        count($album["/common/topic/image"]["/common/topic/image"]) > 0 && !$this->albumExistsInDb($album)){
                        $db_album = new Album();
                        $album_image = $this->image_url_prefix.'/'.$album["/common/topic/image"]["/common/topic/image"][0]["mid"];
                        $db_album->name = $album["name"];
                        $db_album->picture = $album_image.'?maxwidth=225&maxheight=225&mode=fillcropmid';
                        $db_album->service_id = $album["mid"];

                        if(isset($album["/common/topic/description"]["/common/topic/description"])){
                            $db_album->notes = $album["/common/topic/description"]["/common/topic/description"][0];
                        }
                        else{
                            $db_album->notes = "";
                        }
                        $artist->albums()->save($db_album);
                    }
                    else{
                        if($this->albumExistsInDb($album)){
                            if(isset($album["/common/topic/image"]["/common/topic/image"]) &&
                                count($album["/common/topic/image"]["/common/topic/image"]) > 0){
                                $db_album = Album::where('service_id',$album["mid"])->first();
                                $album_image = $this->image_url_prefix.'/'.$album["/common/topic/image"]["/common/topic/image"][0]["mid"];
                                $db_album->name = $album["name"];
                                $db_album->save();
                            }
                        }
                    }
                }

                $artist->load('albums');
            }

            return $artist->toArray();
        }
        else{
            return null;
        }
    }

    private function artistExistsInDb($artist){
        return Artist::where('service_id', $artist["mid"])->count() > 0;
    }

    private function getArtistByMID($mid){
        return Artist::where('service_id', $mid)->first();
    }

    private function albumExistsInDb($album){
        return Album::where('service_id', $album["mid"])->count() > 0;
    }

    public function getSongsByName($name, $limit = null, $language = 'en')
    {
        $query = array(
            'query' => $name,
            'limit' => $limit!==null ? $limit : 10,
            'key' => $this->api_key,
            'lang' => $language,
            'type' => '/music/recording',
            'output' => '(/common/topic/image music)'
//            'output' => '(all)'
        );

        $search_url = "search?".http_build_query($query);
        $request = $this->client->get($search_url);
        $response = $request->send();
        $songs = $response->json();
        $songItems = $songs["result"];

        dd($songItems);

        foreach($songItems as $songItem){
            if($this->songExistsInDb($songItem)){
                $song = $this->getSongByMID($songItem["mid"]);
            }
            else{
                $song = new Song;
                $song->name = $songItem["name"];

//                if(isset($songItem["output"][]))
            }
        }
    }

    public function getSongByID($id)
    {
        // TODO: Implement getSongByID() method.
    }
}

?>