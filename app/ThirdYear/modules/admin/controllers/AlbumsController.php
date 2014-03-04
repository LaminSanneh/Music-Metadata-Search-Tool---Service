<?php
/**
 * Created by PhpStorm.
 * User: Lamin Sanneh
 * Date: 3/3/14
 * Time: 11:27 PM
 */

namespace Modules\Admin\Controllers;
use \Artist as Artist;
use \Album as Album;
use \Song as Song;
use Illuminate\Support\Facades\Redirect;
use \View as View;
use \Input as Input;

class AlbumsController extends \BaseController{

    public function show($id){
        $album = Album::with('songs','artist')->find($id);
        return View::make('admin.albums.albumSongs')->with(compact('album'));
    }

    public function edit($id){
        $album = Album::with('artist')->find($id);
        $artist = $album->artist;
        return View::make('admin.albums.edit')->with(compact('album','artist'));
    }

    public function update($id){
        $data = Input::all();
        $album = Album::find($id);
        if($album->update($data)){
            return Redirect::route('admin.artistAlbums', array($album->artist->id));
        }
        $album = $data;
        return View::make('admin.albums.edit')->with(compact('album'));
    }

    /**
     * Delete the specified album
     */
    public function delete($id){
        $album = Album::find($id);
        $artist_id = $album->artist->id;
        Album::destroy($id);
        return Redirect::route('admin.artistAlbums', array($artist_id));
    }

    /**
     * Show form to create new album song
     */
    public function newAlbumSong($id){
        $song = new Song();
        $album = Album::find($id);
        return View::make('admin.albums.newalbumsong')->with(compact('song','album'));
    }

    /**
     * Save new song for specified album
     */
    public function saveNewAlbumSong($id){
        $data = Input::all();
        $song = new Song($data);
        $album = Album::find($id);
        if($savedSong = $album->songs()->save($song)){
            return Redirect::route('admin.albumDetails', array($album->id));
        }
        return View::make('admin.albums.newalbumsong')->with(compact('song','album'));
    }
} 