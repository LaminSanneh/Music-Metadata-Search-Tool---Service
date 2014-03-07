<?php

use Faker\Factory as Faker;

class AlbumsTableSeeder extends Seeder {

	public function run()
	{
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

		DB::table('albums')->truncate();

        $discogs_albums = DB::connection('discogs')->table('discogs_artists_albums')->get();
        $discogs_songs_table = DB::connection('discogs')->table('discogs_albums_tracks');

        foreach($discogs_albums as $discogs_album){
            $notes = '';
            try{
                $discogs_album_id = $discogs_album->id;
//                $notes = $discogs_songs_table->whereIn("album_id", array($discogs_album_id))->first();
//                if(!isset($notes->notes) || !is_object($notes)){
//                    $notes = '';
//                }
//                else{
//                    $notes = $notes->notes;
//                }
//                if($discogs_album_id === 8){
//                    echo $discogs_album_id."<br/>";
//                    var_dump($notes);
//                }
//                die();
//                Album::create(array(
//                    'name' => $discogs_album->album_name,
//                    'artist_id' => $discogs_album->artist_id,
//                    'release_year' => $discogs_album->year,
//                    'genre' => $discogs_album->genre,
//                    'notes' => $notes->notes,
//                    'picture' => ''
//                ));

                Album::create(array(
                    'name' => $discogs_album->album_name,
                    'artist_id' => $discogs_album->artist_id,
                    'release_year' => $discogs_album->year,
                    'genre' => $discogs_album->genre,
                    'notes' => '',
                    'picture' => ''
                ));
            }
            catch(Exception $e){
//                echo $e->getMessage();
//                print_r($notes);
//                die();

                Album::create(array(
                    'name' => $discogs_album->album_name,
                    'artist_id' => $discogs_album->artist_id,
                    'release_year' => $discogs_album->year,
                    'genre' => $discogs_album->genre,
                    'notes' => '',
                    'picture' => ''
                ));
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
	}

}
