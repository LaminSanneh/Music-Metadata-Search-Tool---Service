<?php
namespace Thirdyear\Services\Implementations\Video;
use \Artist as Artist;
use \Album as Album;
use \Song as Song;
use \ThirdYear\Models\Video as Video;
use Illuminate\Support\Facades\Redirect;
use \View as View;
use \Input as Input;
use \Response as Response;
use \Guzzle\Http\Client as Client;
use \Thirdyear\Services\Interfaces\VideoServiceInterface;
class YoutubeVideoService implements VideoServiceInterface{


    public function getVideosByName($name)
    {
        // TODO: Implement getVideosByName() method.
    }

    public function getVideoById($id)
    {
        // TODO: Implement getVideoById() method.
    }

    public function getRelatedVideos($id)
    {
        // TODO: Implement getRelatedVideos() method.
    }
}
?>