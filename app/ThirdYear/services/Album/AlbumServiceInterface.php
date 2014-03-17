<?php
namespace ThirdYear\Services\Album;
interface AlbumServiceInterface{

    public function getAlbumsByName($name);
    public function getAlbumById($mid);
}

?>