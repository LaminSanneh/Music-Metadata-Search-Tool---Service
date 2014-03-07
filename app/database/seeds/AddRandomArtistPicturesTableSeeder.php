<?php

class AddRandomArtistPicturesTableSeeder extends Seeder {

	public function run()
	{
        $artists = Artist::all();

        $pictures = array(
            'images/artists/eminem.jpg',
            'images/artists/emily-osment.jpg',
            'images/artists/shareefa.jpg',
            'images/artists/emis-killa.jpg'
        );

        $num_of_pics = count($pictures);

        foreach($artists as $artist){
            $random_index = rand(0,$num_of_pics-1);
            $artist->picture = $pictures[$random_index];
            $artist->save();
        }
	}

}
