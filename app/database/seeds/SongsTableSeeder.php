<?php
use Faker\Factory as Faker;

class SongsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		 DB::table('songs')->truncate();

        $faker = Faker::create();

        foreach(range(1,100)as $index){
            Song::create(array(
                'name' => $faker->unique()->sentence(3)
            ));
        }

		// Uncomment the below to run the seeder
//		 DB::table('songs')->insert($songs);
	}

}
