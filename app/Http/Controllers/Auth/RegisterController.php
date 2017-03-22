<?php

namespace App\Http\Controllers\Auth;

use App\Message;
use App\User;
use App\Location;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Libraries\Karibusms;

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
        $karibuSMS = new Karibusms();

        //set a custom name to be used in sending SMS
        $karibuSMS->set_name("DREAMHOMZ");

        $verification_code = generateVerificationCode(4);

        $body = 'Your Dreamhomz verification code is: ' . $verification_code;
        $phone = $data['phone'];
        $message = new Message();

        //Save message in the database

            try {
                $new_user = User::create([
                    'fname' => $data['fname'],
                    'lname' => $data['lname'],
                    'phone' => $data['phone'],
                    'role' => $role,
                    'dp' => "/public/images/uploads/user_dps/drimhomzDefaultDp.png",
                    'password' => bcrypt($data['password']),
                ]);

                $location = [
                    'user_id' => $new_user->id,
                    'long' => null,
                    'lat' => null
                ];
                Location::create($location);
                $message->saveMessage(['body' => $body, 'phone' => $phone, 'verification_code' => $verification_code,'user_id'=>$new_user->id]);
                //$karibuSMS->send_sms($phone,$body);

                return $new_user;
            } catch (\SQLiteException $e) {
                return back()->with('error', $e);
            }





    }

}
