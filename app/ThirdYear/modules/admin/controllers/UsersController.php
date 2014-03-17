<?php
namespace Thirdyear\Modules\Admin\Controllers;

use \View as View;
use \User as User;
use \Role as Role;
use \ApiKey as ApiKey;
use \Auth as Auth;
use \Input as Input;
use \Redirect as Redirect;
use \Validator as Validator;
class UsersController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $users = User::with('roles')->get();
//        dd($users);
        return View::make('admin.users.index')->with(compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $user = new User;
        return View::make('admin.users.create')->with(compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $data = Input::all();
        $user = new User($data);
        if($user->save()){
            $regularUserRole = Role::where('name','LIKE',"%regular%")->first(array('id'))->id;
            $user->addRole($regularUserRole)->save();
            return Redirect::route('admin.users.show',array($user->id));
        }

        return View::make('admin.users.create')->with(compact('user'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $user = User::with('roles','apiKeys')->find($id);
        $roles = $user->roles;
        $other_roles = Role::all()->diff($roles);
        $apiKeys = $user->apiKeys;
        return View::make('admin.users.show')->with(compact('user','roles','other_roles','apiKeys'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return View::make('admin.users.edit')->with(compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $data = Input::all();
        $user = User::find($id);
        if(!isset($data['confirmed'])){
            $data['confirmed'] = false;
        }
        if($user->update($data)){
            return Redirect::route('admin.users.show',array($user->id));
        }

        return View::make('admin.users.edit')->with(compact('user'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        if(User::destroy($id)){
            return redirect::route('admin.users.index')->with('message', 'User deleted successfully');
        }

        return redirect::route('admin.users.index')->with('message', 'User couln\'t be deleted');
    }

    /**
     * Add specified user to specified role
     */
    public function addToRole($id, $role_id){
        $user = User::find($id);
        $user->addRole($role_id);

        return Redirect::route('admin.users.show', array($id));
    }

    /**
     * Remove specified user from specified role
     */
    public function removeFromRole($id, $role_id){
        $user = User::find($id);
        $user->removeRole($role_id);

        return Redirect::route('admin.users.show', array($id));
    }

    /**
     * @param $userId
     * @param $keyId
     * Activates an api key for the specified user
     */
    public function activateApiKey($keyId){
        $key = ApiKey::find($keyId);
        $key->is_active = true;
        $key->save();
        return Redirect::back();
    }

    /**
     * @param $userId
     * @param $keyId
     * DeActivates an api key for the specified user
     */
    public function deActivateApiKey($keyId){
        $key = ApiKey::find($keyId);
        $key->is_active = false;
        $key->save();
        return Redirect::back();
    }

    public function requestNewApiKey(){
        $data = Input::only('domain');
        $apiKey = new ApiKey(array(
            'domain' => $data['domain'],
            'key' => sha1(mt_rand(10000,99999).time()),
            'is_active' => false
        ));

        Auth::user()->apiKeys()->save($apiKey);
        return Redirect::route('account')->with('message', 'New api key requested and waiting to be approved');
    }

    public function deleteApiKey($keyId){
        ApiKey::destroy($keyId);
        return Redirect::back()->with('message','Api Key deleted successfully');
    }
}