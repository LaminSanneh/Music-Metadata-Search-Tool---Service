<?php

namespace Thirdyear\Modules\Admin\Controllers;

use \View as View;
use \User as User;
use \Role as Role;
use \Auth as Auth;
use \Input as Input;
use \Redirect as Redirect;
use \Validator as Validator;
class RolesController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $roles = Role::all();
        return View::make('admin.roles.index')->with(compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $role = new Role();
        return View::make('admin.roles.create')->with(compact('role'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $data = Input::only('name');
        $role = new Role($data);
        if($role->save()){
            return Redirect::route('admin.roles.index')->with('message','New Role Successfully Created');
        }

        return View::make('admin.roles.create')->with(compact('role'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
//		$role = Role::find($id);
//        return View::make('')
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $role = Role::find($id);
        return View::make('admin.roles.edit')->with(compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $data = Input::only('name');
        $role = Role::find($id);
        if($role->update($data)){
            return Redirect::route('admin.roles.index')->with('message','Role Successfully Updated');
        }

        return View::make('admin.roles.edit')->with(compact('role'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        if(Role::destroy($id)){
            return Redirect::route('admin.roles.index');
        }

        return Redirect::route('admin.roles.index')->with('message','Could Not delete role with id: '.$id);
    }

}