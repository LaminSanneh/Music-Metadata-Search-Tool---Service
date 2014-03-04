<?php

class DiscogsArtistAlbumsTableSeeder extends Seeder {

	public function run()
	{
        $builder = Schema::connection('discogs');
        $builder->dropIfExists('discogs_artists_albums');
        if(!$builder->hasTable('discogs_artists_albums')){
            $builder->create('discogs_artists_albums', function($table){
                $table->increments('id');
                $table->integer('artist_id');
                $table->string('album_name')->nullable();
                $table->string('thumb')->nullable();
                $table->string('country')->nullable();
                $table->string('year')->nullable();
                $table->string('genre')->nullable();
                $table->string('discogs_release_id')->nullable();
            });
        }

        $artist_infos = DB::connection('discogs')->table('discogs_artists_infos')->get();
        $artist_albums_table = DB::connection('discogs')->table('discogs_artists_albums');
        $artist_albums_table->truncate();

        $service = new \Discogs\Service();
        $guzzleClient = new \Guzzle\Http\Client('http://api.discogs.com');

        foreach($artist_infos as $artist_info){
            try{
                $releases = $service->getReleases($artist_info->discogs_artist_id);
                $releases = $service->search(array(
                    'q'     => $artist_info->artist_name,
                    'type' => 'release',
//                'releases' => 1
                ));
//            dd($artist_info);
//            $response = $guzzleClient->get('artists/'.$artist_info->discogs_artist_id.'/releases')->send();
//            dd($response->getBody());
//                dd($releases->getResults());
                foreach($releases as $release){
                    $genreArray = $release->getGenre();
                    $album = array(
                        'artist_id' =>$artist_info->id,
                        'album_name' =>$release->getTitle(),
                        'thumb' =>$release->getThumb(),
                        'country' =>$release->getCountry(),
                        'year' =>$release->getYear(),
                        'genre' => $genreArray[0],
                        'discogs_release_id' =>$release->getId(),
                    );
                    $artist_albums_table->insert($album);
                }
                sleep(1);
            }
            catch(Exception $e){
                echo $e->getMessage();
            }
        }
	}

}
