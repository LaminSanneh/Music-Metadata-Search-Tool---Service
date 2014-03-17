<?php
namespace ThirdYear\Services\Song;
interface SongServiceInterface{

    public function getSongsByName($name);
    public function getSongByID($id);
}

?>