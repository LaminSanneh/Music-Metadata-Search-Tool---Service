<?php
namespace Thirdyear\Modules\Admin\Controllers;

use \View as View;
use \User as User;
use \Role as Role;
use \Auth as Auth;
use \Input as Input;
use \Redirect as Redirect;
use \Validator as Validator;
use Whoops\Example\Exception;

class AuthController extends \BaseController{

    public function showLoginForm(){
        $user = new User;
        return View::make('publicarea.showLoginForm')->with(compact('user'));
    }

    public function handleLogin(){
        $data = Input::only('email','password');
        if(Auth::attempt($data)){
            return Redirect::route('account')->with('message','Logged in successfully');
        }
        else{
        return Redirect::back()->withInput()->with('message','Username or password wrong');
        }
    }

    public function logout(){
        Auth::logout();
        if(Auth::check()){
           return Redirect::back()->with('message','Error logging out');
        }
        else{
            return Redirect::route('home')->with('message','Logged out successfully');
        }
    }

    public function showRegistrationForm(){
        $user = new User;
        return View::make('publicarea.showRegistrationForm')->with('user',$user);
    }

    public function handleRegistration(){

        $data = Input::only('email','password','password_confirmation');

        $rules = array(
            'email'=> 'required:email',
            'password'=> 'required|min:5|confirmed',
            'password_confirmation'=> 'required|min:5'
        );

        $validator = Validator::make($data,$rules);
        if($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
        }

        if($this->userWithEmailAlreadyExists($data['email'])){
            return Redirect::back()->withInput()->with('message','That email already exists');
        }

        $confirmCode = sha1(mt_rand(10000,99999).time().$data["email"]);

        $newUser = User::create(array(
            'email' => $data['email'],
            'password' => \Hash::make($data['password']),
            'confirmed' => false,
            'email_confirm_token' => $confirmCode,
            'first_name' => 'Anonymous'
        ));

        if(!$newUser){
            return Redirect::back()->withInput()->with('message','Validation passed but User creation failed in database');
        }
        else{
            $regularUserRole = Role::where('name','LIKE',"%regular%")->first(array('id'))->id;
            $newUser->addRole($regularUserRole)->save();
            $this->sendNewUserEmail($newUser);
        }

        return Redirect::route('login')->with('message','Successfully Registered');
    }

    public function userWithEmailAlreadyExists($email){
        return User::where('email', $email)->count() > 0;
    }

    public function sendNewUserEmail($newUser){

        $sent = \Mailgun::send(array('emails.new-user-notification'), $newUser->toArray(), function($message) use($newUser)
        {
            $message->to($newUser->email, $newUser->first_name)->subject('Musica Api Account Activation Code');
        });

        return Redirect::route('account');
    }

    /**
     * Shows accounts page for current logged in user
     */
    public function account(){
        $apiKeys = Auth::user()->apiKeys;
        return View::make('admin.users.account')->with(compact('apiKeys'));
    }

    /**
     * Activates the current user aacount if it is not
     */
    public function activateUserAccount(){
        $currentUser = Auth::user();
        if(!$currentUser->confirmed){
            $data = Input::only('activation_code');
            if(User::where('email_confirm_token',$data['activation_code'])->where('id', $currentUser->id)->count() == 1){
                $currentUser->confirmed = true;
                $currentUser->save();
                return Redirect::route('account')->with('message','Account now activated');
            }
            else{
                return Redirect::back()->with('message','Confirm code is invalid, please request another one or retype correctly');
            }
        }
        return View::make('admin.users.account');
    }

    public function resendEmailConfirm(){
        $currentUser = Auth::user();
        if(!$currentUser->confirmed){
            $confirmCode = sha1(mt_rand(10000,99999).time().$currentUser->email);
            $currentUser->email_confirm_token = $confirmCode;
            $currentUser->save();
            $this->sendNewUserEmail($currentUser);
            return Redirect::route('account')->with('message','Please Check your email for new code');
        }
        else{
            return Redirect::route('account')->with('message','Account already activated');
        }
    }
} 