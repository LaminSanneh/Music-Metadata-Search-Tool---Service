<?php

use Faker\Factory as Faker;

class ArtistsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		 DB::table('artists')->truncate();

        $faker = Faker::create();

        foreach(range(1,100)as $index){
            Artist::create(array(
                'name' => $faker->unique()->sentence(3)
            ));
        }

		// Uncomment the below to run the seeder
		// DB::table('artists')->insert($artists);
	}

}
