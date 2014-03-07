<?php

use Faker\Factory as Faker;

class ArtistsTableSeeder extends Seeder {

	public function run()
	{
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

		DB::table('artists')->truncate();

        $faker = Faker::create();

        $artists = DB::connection('discogs')->table('discogs_artists_infos')->get();

        foreach($artists as $artist){
            Artist::create(array(
                'name' => $artist->artist_name,
                'real_name' => $artist->real_name,
                'profile' => $artist->profile,
                'picture' => ''
            ));
        }

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

		// Uncomment the below to run the seeder
		// DB::table('artists')->insert($artists);
	}

}
