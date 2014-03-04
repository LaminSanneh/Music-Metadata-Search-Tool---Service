<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::group(array('prefix' => 'admin', 'namespace' => '\Modules\Admin\Controllers'), function(){

    //Artists
    Route::get('artists/index',array('as' => 'admin.artists', 'uses' => 'ArtistsController@index'));
    Route::get('artists/edit/{id}',array('as' => 'admin.editArtist', 'uses' => 'ArtistsController@edit'));
    Route::post('artists/update/{id}',array('as' => 'admin.updateArtist', 'uses' => 'ArtistsController@update'));
    Route::get('artists/new',array('as' => 'admin.newArtist', 'uses' => 'ArtistsController@newArtist'));
    Route::post('artists/saveNew',array('as' => 'admin.saveNewArtist', 'uses' => 'ArtistsController@saveNewArtist'));
    Route::get('artists/delete/{id}',array('as' => 'admin.deleteArtist', 'uses' => 'ArtistsController@delete'));

    //ArtistAlbums
    Route::get('artists/{id}/albums',array('as' => 'admin.artistAlbums', 'uses' => 'ArtistsController@artistAlbums'));
    Route::get('artists/{id}/albums/new',array('as' => 'admin.newArtistAlbum', 'uses' => 'ArtistsController@newArtistAlbum'));
    Route::post('artists/{id}/albums/saveNew',array('as' => 'admin.saveNewArtistAlbum', 'uses' => 'ArtistsController@saveNewArtistAlbum'));

    //Albums
    Route::get('albums/{id}',array('as' => 'admin.albumDetails', 'uses' => 'AlbumsController@show'));
    Route::get('albums/{id}/edit',array('as' => 'admin.editAlbum', 'uses' => 'AlbumsController@edit'));
    Route::post('albums/{id}/update',array('as' => 'admin.updateAlbum', 'uses' => 'AlbumsController@update'));
    Route::get('albums/delete/{id}',array('as' => 'admin.deleteAlbum', 'uses' => 'AlbumsController@delete'));

    //Songs
    Route::post('songs/{id}/update', array('as' => 'admin.updateSong', 'uses' => 'SongsController@update'));
    Route::get('songs/{id}/delete', array('as' => 'admin.deleteSong', 'uses' => 'SongsController@delete'));

    //Album Songs
    Route::get('albums/{id}/songs/new', array('as' => 'admin.newAlbumSong', 'uses' => 'AlbumsController@newAlbumSong'));
    Route::post('albums/{id}/songs/saveNew', array('as' => 'admin.saveNewAlbumSong', 'uses' => 'AlbumsController@saveNewAlbumSong'));
});


Route::get('/', array('as' => 'home', 'uses' => 'HomeController@index'));

Route::resource('songs', 'SongsController');

Route::resource('artists', 'ArtistsController');

Route::resource('albums', 'AlbumsController');