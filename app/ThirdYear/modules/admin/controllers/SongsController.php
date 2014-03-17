<?php
/**
 * Created by PhpStorm.
 * User: Lamin Sanneh
 * Date: 3/4/14
 * Time: 11:24 AM
 */

namespace Thirdyear\Modules\Admin\Controllers;

use \Artist as Artist;
use \Album as Album;
use \Song as Song;
use Illuminate\Support\Facades\Redirect;
use \View as View;
use \Input as Input;
class SongsController extends \BaseController{

    public function update($id){
        $data = Input::all();
        $song = Song::with('album')->find($id);

        if($song->update($data)){
            return Redirect::route('admin.albumSongs',array($song->album->id));
        }

        return View::make('admin.songs.edit')->with(compact('song'));
    }

    /**
     * Delete specified song
     */
    public function delete($id){
        $album_id = Song::with('album')->find($id)->album->id;
        Song::destroy($id);
        return Redirect::route('admin.albumDetails', array($album_id));
    }
} 