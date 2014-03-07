<?php
use Faker\Factory as Faker;

class SongsTableSeeder extends Seeder {

	public function run()
	{
         DB::statement('SET FOREIGN_KEY_CHECKS = 0');

		 DB::table('songs')->truncate();

        $discogs_albums_tracks = DB::connection('discogs')->table('discogs_albums_tracks')->get();

        foreach($discogs_albums_tracks as $discogs_albums_track){
            Song::create(array(
                'name' => $discogs_albums_track->title,
                'album_id' => $discogs_albums_track->album_id
            ));
        }

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }

}
