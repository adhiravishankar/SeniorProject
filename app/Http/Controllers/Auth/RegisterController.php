<?php

namespace Caesar\Http\Controllers\Auth;

use Auth;
use Caesar\Http\Controllers\Controller;
use Caesar\User;
use Google_Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('guest');
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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     */
    protected function create(array $data)
    {
        $user = $this->datastore->entity('User', [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        $this->datastore->insert($user);
    }

    /**
     *
     *
     * @param Request $request
     */
    protected function googleRegistration(Request $request)
    {
        $client = new Google_Client(['client_id' => '528963535795-c6tp6j333s3ehvhgemfngecdbt8f0iln.apps.googleusercontent.com']);
        $payload = $client->verifyIdToken($request->get('id_token'));
        if ($payload) {
            $userid = $payload['sub'];
            $name = $payload['name'];
            $picture = $payload['picture'];
            $email = $payload['email'];
            $users = iterator_to_array($this->datastore->runQuery($this->datastore->query()->kind('User')
                ->filter('google_user_id', '=', $userid)));
            if (collect($users)->count() > 0) {
                Auth::login(User::createUser($users[0]));
                redirect('profile');
            } else {
                $user = new User($this->datastore->key('User'), ['google_user_id' => $userid, 'name' => $name,
                    'picture' => $picture, 'email' => $email], ['excludeFromIndexes' => ['picture']]);
                $this->datastore->insert($user);
                Auth::login($user);
                redirect('profile');
            }
        } else {
            redirect('login');
        }
    }
}
