<?php

namespace App\Http\Controllers\Auth;

use App\Events\WelcomeUser;
use App\User;
use Facebook\Facebook;
use Illuminate\Support\Facades\Auth;
use League\Flysystem\Exception;
use SammyK\LaravelFacebookSdk\LaravelFacebookSdk;
use Symfony\Component\Debug\Exception\FatalErrorException;
use Validator;
use Webpatser\Uuid\Uuid;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Socialite;
use Illuminate\Support\Facades\Event;

class AuthController extends Controller
{

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')
                        ->scopes(['email', 'user_birthday','user_about_me','user_education_history',
                                  'user_location','user_work_history','user_hometown','user_likes'])
                        ->redirect();
    }


    /**
     * Obtain the user information from Facebook.
     *
     * @return Response
     */
    public function handleProviderCallback()

    {
        $user = Socialite::driver('facebook')->user();

        $gender     =  $user->user['gender'];
        $ext_id     =  $user->user['id'];
        $verified   =  $user->user['verified'];
        $avatar     =  $user->avatar;
        $name = explode(' ',$user->name);


        $social_exist = User::where('ext_id',$ext_id)->first();


        if($social_exist)
        {
            return $this->loginUsingId($social_exist->id);
        }
        else
        {
            $user_create = User::create([
                'uuid'      => Uuid::generate(5,$user->email, Uuid::NS_DNS),
                "firstname"    => "$name[0]",
                "lastname"     => "$name[1]",
                "email"        => "$user->email",
                'password'     =>  bcrypt($ext_id),
                "gender"       => "$gender",
                "avatar"       =>  $avatar,
                "ext_id"       =>  $ext_id,
                "ext_source"   => "facebook",
                "ext_verified" => "$verified"
            ]);

            $userObj = User::find($user_create->id);

            if(Event::fire(new WelcomeUser($user_create)))
            {
                return $this->loginUsingId($user_create->id);
            }else
            {
                //Redirect to error page and log in the incident
            }
        }
    }


    /**
     * Log using using primary key
     * @params int $id
     * @return Redirect
     */
    public function loginUsingId($id)
    {
        Auth::user();
        $user = Auth::loginUsingId($id,true);
        if($user)
        {
            return redirect('/init_check');
        }else{
            echo "unable to login";
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/init_check';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstname' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'uuid'      => Uuid::generate(5,$data['email'], Uuid::NS_DNS),
            'firstname' => $data['firstname'],
            'lastname'  => $data['lastname'],
            'email'     => $data['email'],
            'password'  => bcrypt($data['password']),
        ]);

        $userObj = User::find($user->id);

        if(Event::fire(new WelcomeUser($userObj)))
        {
            return $user;
        }else
        {
            //Redirect to error page and log in the incident
        }

    }
}
