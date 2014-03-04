<?php

class DiscogsAlbumTracksTableSeeder extends Seeder {

	public function run()
	{
        $builder = Schema::connection('discogs');
        $builder->dropIfExists('discogs_albums_tracks');
        if(!$builder->hasTable('discogs_albums_tracks')){
            $builder->create('discogs_albums_tracks', function($table){
                $table->increments('id');
                $table->string('title');
                $table->string('duration')->nullable();
                $table->integer('album_id');
                $table->string('notes')->nullable();
            });
        }

        $artist_albums = DB::connection('discogs')->table('discogs_artists_albums')->get();
        $albums_tracks_table = DB::connection('discogs')->table('discogs_albums_tracks');
        $albums_tracks_table->truncate();

        $service = new \Discogs\Service();

        foreach($artist_albums as $artist_album){
            try{
                $tracks = $service->getRelease($artist_album->discogs_release_id);
//                dd($tracks);

                $album_note = $tracks->getNotes();
                $tracks_list = $tracks->getTracklist();

                $index = 1;
                foreach($tracks_list as $track){
                    $albums_tracks_table->insert(array(
                        'title' => $track->getTitle(),
                        'duration' => $track->getDuration(),
                        'notes' => $album_note,
                        'album_id' => $artist_album->id
                    ));

                    if($index == 1){
                        $album_note = '';
                    }
                    $index++;
                }
                sleep(2);
            }
            catch(Exception $e){
                echo $e->getMessage();
            }
        }

    }

}
