<?php

use Guzzle\Plugin\Oauth\OauthPlugin;
class DiscogsArtistInfosTableSeeder extends Seeder {

	public function run()
	{
        $builder = Schema::connection('discogs');
        $builder->dropIfExists('discogs_artists_infos');
        if(!$builder->hasTable('discogs_artists_infos')){
            $builder->create('discogs_artists_infos', function($table){
                $table->increments('id');
                $table->integer('discogs_artist_id');
                $table->string('artist_name')->nullable();
                $table->string('real_name')->nullable();
                $table->text('profile')->nullable();
                $table->string('releases_url')->nullable();
            });
        }

        $artist_ids = DB::connection('discogs')->table('discogs_artists_ids')->select('artist_id','artist_name')->get();
        $artist_infos_table = DB::connection('discogs')->table('discogs_artists_infos');
        $artist_infos_table->truncate();

//        $service = new \Discogs\Service();

        $error = null;

//        $guzzleClient = new \Guzzle\Http\Client('http://api.discogs.com');
//        $guzzleClient->setUserAgent('ThirdyearClient/0.1 +https://thirdyearClient.com');
//        $oauth = new OauthPlugin(array(
//            'consumer_key'    => 'zaiKXQfcHNYSarqJlQRv',
//            'consumer_secret' => 'YfynHLZCQXccwnWzQFLlKUfFOcuRrFrO'
//        ));
//        $guzzleClient->addSubscriber($oauth);

        try{
            foreach($artist_ids as $artist_id){
                try{
//                $request = $guzzleClient->get('artists/'.$artist_id->artist_id.'/releases');
//                $response = $request->send();
//                $artist = $response->getBody()->get
//                dd($response);
                        $service = new \Discogs\Service();
                        if(!is_null($artist_id) && !empty($artist_id)){
                            $artist = $service->getArtist($artist_id->artist_id);
                            $error = $artist;
                            $real_name = $artist->getRealname();
                            if(is_null($real_name)){
                                $real_name = $artist->getName();
                            }
                            $artist_info = array(
                                'discogs_artist_id' => $artist_id->artist_id,
                                'artist_name' => $artist_id->artist_name,
                                'real_name' => $real_name,
                                'profile' => $artist->getProfile(),
                                'releases_url' => $artist->getReleasesUrl()
                            );

                            $artist_infos_table->insert($artist_info);
                        }
                    sleep(1);
                }
                catch(Exception $e){
                    echo $e->getMessage();
                    if($e->getCode() == 404){
                        continue;
                    }
                }
            }
        }
        catch(Exception $e){
            echo $e->getMessage();
            print_r($error);
        }

		// Uncomment the below to run the seeder
	}

}
