<?php
use Faker\Factory as Faker;

class SongsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		 DB::table('songs')->truncate();

        $discogs_albums_tracks = DB::connection('discogs')->table('discogs_albums_tracks')->get();

        foreach($discogs_albums_tracks as $discogs_albums_track){
            Song::create(array(
                'name' => $discogs_albums_track->title,
                'album_id' => $discogs_albums_track->album_id
            ));
        }
    }

}
