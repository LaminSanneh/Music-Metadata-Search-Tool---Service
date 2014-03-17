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
Route::group(array('namespace' => 'Thirdyear\Modules\PublicArea\Controllers'), function(){
    Route::get('/', array('as' => 'home', 'uses' => 'PublicController@index'));
});


Route::group(array('prefix' => 'admin', 'namespace' => 'Thirdyear\Modules\Admin\Controllers', 'before' => 'super-user'), function(){

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


    //Roles and Users
    Route::resource('roles', 'RolesController');
    Route::resource('users', 'UsersController');


    Route::get('users/{id}/addToRole/{role_id}',
        array('as' => 'admin.users.addToRole', 'uses' => 'UsersController@addToRole'));
    Route::get('users/{id}/removeFromRole/{role_id}',
        array('as' => 'admin.users.removeFromRole', 'uses' => 'UsersController@removeFromRole'));

    //Api Keys
    Route::get('activateApiKey/{keyId}', array('as' => 'activateApiKey', 'uses' => 'UsersController@activateApiKey'));
    Route::get('deActivateApiKey/{keyId}', array('as' => 'deActivateApiKey', 'uses' => 'UsersController@deActivateApiKey'));
});

//Login, register and stuff like that
Route::group(array('prefix' => 'regular', 'namespace' => 'Thirdyear\Modules\Admin\Controllers'), function(){
    Route::get('login', array('as' => 'login', 'uses' => 'AuthController@showLoginForm'));
    Route::post('login', array('as' => 'login', 'uses' => 'AuthController@handleLogin', 'before' => 'csrf'));
    Route::get('logout', array('as' => 'logout', 'uses' => 'AuthController@logout'));
    Route::get('register', array('as' => 'register', 'uses' => 'AuthController@showRegistrationForm'));
    Route::post('register', array('as' => 'register', 'uses' => 'AuthController@handleRegistration', 'before' => 'csrf'));
});

Route::group(array('prefix' => 'regular', 'namespace' => 'Thirdyear\Modules\Admin\Controllers', 'before' => 'auth'), function(){
    //Api Keys
    Route::post('requestNewApiKey', array('as' => 'requestNewApiKey', 'uses' => 'UsersController@requestNewApiKey'));
    Route::get('deleteApiKey/{keyId}', array('as' => 'deleteApiKey', 'uses' => 'UsersController@deleteApiKey'));

    //Auth
    Route::get('account', array('as' => 'account', 'uses' => 'AuthController@account'));
    Route::get('resendEmailConfirm', array('as' => 'resendEmailConfirm', 'uses' => 'AuthController@resendEmailConfirm'));
    Route::post('activateUserAccount', array('as' => 'activateUserAccount', 'uses' => 'AuthController@activateUserAccount'));
});


Route::group(array('prefix' => 'api/v1', 'namespace' => 'Thirdyear\Modules\Api\V1\Controllers'), function(){
    Route::resource('artists', 'ArtistsController');
    Route::resource('songs', 'SongsController');
    Route::resource('albums', 'AlbumsController');
    Route::get('videos/popularVideos', array('as' => 'popularVideos', 'uses' => 'VideosController@popularVideos'));
    Route::resource('videos', 'VideosController');
});

