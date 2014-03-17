<?php
namespace ThirdYear\Services\Artist;
interface ArtistServiceInterface{

    public function getArtistsByName($name);
    public function getArtistByID($mid);
}

?>