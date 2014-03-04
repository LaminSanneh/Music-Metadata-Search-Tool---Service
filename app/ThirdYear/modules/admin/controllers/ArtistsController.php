<?php
/**
 * Created by PhpStorm.
 * User: Lamin Sanneh
 * Date: 3/3/14
 * Time: 9:04 PM
 */

namespace Modules\Admin\Controllers;
use \Artist as Artist;
use \Album as Album;
use Illuminate\Support\Facades\Redirect;
use \View as View;
use \Input as Input;

class ArtistsController extends \BaseController{

    public function index(){
        $artists = Artist::all();
        return View::make('admin.artists.index')->with(compact('artists'));
    }

    public function edit($id){
        $artist = Artist::find($id);
        return View::make('admin.artists.edit')->with(compact('artist'));
    }

    public function update($id){
//        $id = Input::get('id');
        $artist = Artist::find($id);
        $data = Input::only('name','real_name','profile');

        if($artist->update($data)){
            return Redirect::route('admin.artists');
        }

        return View::make('admin.artists.edit')->with(compact('artist'));

    }

    public function artistAlbums($id){
        $artist = Artist::with('albums')->find($id);
        return View::make('admin.artists.artistalbums')->with(compact('artist'));
    }

    /**
     * SHow form to create new artist
     */
    public function newArtist(){
        $artist = new Artist();
        return View::make('admin.artists.newArtist')->with(compact('artist'));
    }

    /**
     * Save artist from new artist form
     */
    public function saveNewArtist(){
        $data = Input::all('');
        $artist = new Artist($data);
        if($artist->save()){
            return Redirect::route('admin.artists');
        }
        return View::make('admin.artists.newArtist')->with(compact('artist'));
    }

    /**
    * Delete the specified artist
    */
    public function delete($id){
        Artist::destroy($id);
        return Redirect::route('admin.artists');
    }

    /**
     * Show form to create new album for artist
     */
    public function newArtistAlbum($id){
        $artist = Artist::find($id);
        $album = new Album();
        return View::make('admin.artists.newartistalbum')->with(compact('album','artist'));
    }

    /**
     * Save new album for artist
     */
    public function saveNewArtistAlbum($id){
        $data = Input::all();
        $artist = Artist::find($id);
        $album = new Album($data);
        if($artist->albums()->save($album)){
            return Redirect::route('admin.artistAlbums', array($id));
        }
        return View::make('admin.artists.newartistalbum')->with(compact('album','artist'));
    }
} 