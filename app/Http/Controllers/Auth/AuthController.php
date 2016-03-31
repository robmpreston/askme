<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Laravel\Socialite\Contracts\Factory as Socialite;

use Auth;
use Session;
use Log;

class AuthController extends Controller
{
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
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(Socialite $socialite = null)
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
        $this->socialite = $socialite;
    }

    public function getSocialAuth($provider=null)
    {
        if(!config("services.$provider")) abort('404'); //just to handle providers that doesn't exist
        return $this->socialite->with($provider)->redirect();
    }

    public function getSocialAuthCallback($provider=null)
    {
        $user = $this->socialite->with($provider)->user();
        if ($user) {
            if ($provider == 'facebook') {
                return $this->facebookCreateOrLogin($user);
            }
        }
        if($user = $this->socialite->with($provider)->user()){
            dd($user);
        }
        return 'something went wrong';
    }

    public function ajaxLogin(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], true, true)) {
            return [
                'success' => true,
                'data' => [ 'user' => Auth::user() ],
                'check' => Auth::check(),
                'error' => null
            ];
        }
        return [
            'success' => false,
            'data' => null,
            'error' => null
        ];
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
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
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
        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'slug' => User::createSlug($data['first_name'], $data['last_name']),
            'password' => bcrypt($data['password']),
        ]);
    }

    protected function facebookCreateOrLogin($data)
    {
        // Check If User Exists
        log::error('Facebook Data');
        log::error(json_encode($data));
        log::error('End');
        $user = User::getByEmail($data->email);
        if ($user && $user->facebook_id) {
            Auth::login($user);
            return redirect()->intended('/');
        }

        // user exists but facebook ID is not saved
        if ($user && !$user->facebook_id) {
            $user->first_name = $data->user['first_name'];
            $user->last_name = $data->user['last_name'];
            $user->facebook_id = $data->id;
            $user->save();
            Auth::login($user);
            return redirect()->intended('/');
        }

        // new user
        $user = new User;
        $user->first_name = $data->user['first_name'];
        $user->last_name = $data->user['last_name'];
        $user->email = $data->email;
        $user->slug = User::createSlug($data->user['first_name'], $data->user['last_name']);
        $user->facebook_id = $data->id;
        $user->password = Hash::make($data->id . self::salt());
        $user->save();
        Auth::login($user);
        return redirect()->intended('/');
    }

    public static function salt()
    {
        return 'JRobKeepYourDayJob';
    }
}
