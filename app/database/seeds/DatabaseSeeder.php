<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		// $this->call('UserTableSeeder');
		$this->call('SongsTableSeeder');
		$this->call('ArtistsTableSeeder');
		$this->call('AlbumsTableSeeder');
	}

}