<?php
/**
 * Created by PhpStorm.
 * User: Lamin Sanneh
 * Date: 3/13/14
 * Time: 6:06 PM
 */

namespace ThirdYear\Services\Transformers;

use \Artist;
use \League\Fractal\TransformerAbstract;
class ArtistTransformer extends TransformerAbstract{

    protected $availableEmbeds = [
        'albums'
    ];

    public function transform(array $artist){
        return [
            'id' => $artist["id"],
            'real_name' => $artist["real_name"],
            'profile' => $artist["profile"],
            'picture' => $artist["picture"],
            'service_id' => $artist["service_id"]
        ];
    }

    public function embedAlbums(array $artist){
        $albums = $artist["albums"];
        $collection = $this->collection($albums, new AlbumTransformer());
//        dd($collection);
        return $collection;
    }
} 