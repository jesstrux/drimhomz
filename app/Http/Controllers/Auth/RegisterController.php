<?php

namespace App\Http\Controllers\Auth;

use App\Message;
use App\User;
use App\Location;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
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
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/verifyPhoneNumber';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'fname' => 'required|max:255',
            'lname' => 'required|max:255',
            'phone' => 'required|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     *
     * @return User
     */
    protected function create(array $data)
    {
        $role = $data['role'];

        if (!isset($role) || strlen($role) < 1)
            $role = "user";

        if (!isset($expertise) || strlen($expertise) < 1)
            $expertise = "user";


        $verification_code = generateVerificationCode(4);

        $body = 'Your Dreamhomz verification code is: ' . $verification_code;
        $message = new Message();

        //Save message in the database

            try {
                $new_user = User::create([
                    'fname' => $data['fname'],
                    'lname' => $data['lname'],
                    'phone' => $data['phone'],
                    'verification_code' => $verification_code,
                    'role' => $role,
                    'dp' => "drimhomzDefaultDp.png",
                    'password' => bcrypt($data['password']),
                ]);

                $location = [
                    'user_id' => $new_user->id,
                    'long' => null,
                    'lat' => null
                ];
                Location::create($location);
                $message->saveMessage(['body' => $body,'user_id'=>$new_user->id]);
                Artisan::call("schedule:run");

                return $new_user;
            } catch (\SQLiteException $e) {
                return back()->withErrors(['error'=> $e]);
            }





    }

}
