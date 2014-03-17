<?php
//Declare ioc bindings
namespace ThirdYear\Services;
use Illuminate\Support\ServiceProvider;
use ThirdYear\Services\Artist\FreebaseArtistService;

class IocBindingServiceProvider extends ServiceProvider{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $app = $this->app;
        $app->bind('ThirdYear\Services\Artist\ArtistServiceInterface', 'ThirdYear\Services\Artist\FreebaseArtistService');
        $app->bind('ThirdYear\Services\Album\AlbumServiceInterface', 'ThirdYear\Services\Album\FreebaseAlbumService');
        $app->bind('ThirdYear\Services\Song\SongServiceInterface', 'ThirdYear\Services\Song\FreebaseSongService');
    }
}

?>