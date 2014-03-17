<?php
/**
 * Created by PhpStorm.
 * User: Lamin Sanneh
 * Date: 3/13/14
 * Time: 6:36 PM
 */

namespace ThirdYear\Services\Transformers;

use \Artist;
use \Album;
use \League\Fractal\TransformerAbstract;
class AlbumTransformer extends TransformerAbstract{

    public function transform(array $album){
        return [
            'id' => $album["id"],
            'name' => $album["name"],
            'genre' => $album["genre"],
            'notes' => $album["notes"],
            'picture' => $album["picture"],
            'service_id' => $album["service_id"]
        ];
    }
} 