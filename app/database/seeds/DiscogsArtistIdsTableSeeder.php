<?php

class DiscogsArtistIdsTableSeeder extends Seeder {

	public function run()
	{
        $builder = Schema::connection('discogs');
        if(!$builder->hasTable('discogs_artists_ids')){
            $builder->create('discogs_artists_ids', function($table){
                $table->increments('id');
                $table->integer('artist_id');
                $table->string('artist_name');
            });
        }

        $table = DB::connection('discogs')->table('discogs_artists_ids');
		 $table->truncate();

        $artist_names = array(
            'The Beatles','Elvis Presley','Prince','U2','Nirvana','Madonna','Kanye West','Jay-Z','Metallica',
            'Guns N\' Roses','Eminem','Elton John','Daft Punk','Beyonce','The Notorious B.I.G.','Wu-Tang Clan','Amy Winehouse','Justin Timberlake',
            'Snoop Dogg','Foo Fighters','2Pac','Ice Cube','Janet Jackson','Britney Spears','Raekwon','Rihanna','Bon Jovi',
            'Lil Wayne','Usher','Youssou N\'Dour','Muse','Adele','50 Cent','Cee-Lo','R. Kelly','Alicia Keys','Band of Horses',
//            'Eminem','Beyonce','Beyonce','Eminem','Beyonce','Beyonce','Eminem','Beyonce','Beyonce',
//            'Eminem','Beyonce','Beyonce','Eminem','Beyonce','Beyonce','Eminem','Beyonce','Beyonce',
//            'Eminem','Beyonce','Beyonce','Eminem','Beyonce','Beyonce','Eminem','Beyonce','Beyonce',
//            'Eminem','Beyonce','Beyonce','Eminem','Beyonce','Beyonce','Eminem','Beyonce','Beyonce',
//            'Eminem','Beyonce','Beyonce','Eminem','Beyonce','Beyonce','Eminem','Beyonce','Beyonce',
//            'Eminem','Beyonce','Beyonce','Eminem','Beyonce','Beyonce','Eminem','Beyonce','Beyonce',
//            'Eminem','Beyonce','Beyonce','Eminem','Beyonce','Beyonce','Eminem','Beyonce','Beyonce'
        );

        $service = new \Discogs\Service();
        foreach($artist_names as $artist_name){
            $resultset = $service->search(array(
            'q'     => $artist_name,
            'type' => 'artist'
            ));

            $results = $resultset->getResults();
            $artist = array(
                'artist_id' => $results[0]->getId(),
                'artist_name' => $results[0]->getTitle()
            );
            $table->insert($artist);

            $artist = array(
                'artist_id' => $results[1]->getId(),
                'artist_name' => $results[1]->getTitle()
            );
            $table->insert($artist);

            $artist = array(
                'artist_id' => $results[2]->getId(),
                'artist_name' => $results[2]->getTitle()
            );
            $table->insert($artist);
            sleep(1);
        }


        // Uncomment the below to run the seeder
	}

}
