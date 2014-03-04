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
//		$this->call('ArtistsTableSeeder');
//		$this->call('AlbumsTableSeeder');
		$this->call('SongsTableSeeder');
//		$this->call('DiscogsArtistIdsTableSeeder');
//		$this->call('DiscogsArtistInfosTableSeeder');
//		$this->call('DiscogsArtistAlbumsTableSeeder');
//		$this->call('DiscogsAlbumTracksTableSeeder');
	}

}