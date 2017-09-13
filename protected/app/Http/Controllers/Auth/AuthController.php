<?php

namespace App\Http\Controllers\Auth;

use App\Http\Models\Users;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Session;

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
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
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
            'nama_user' 		=> 'required|max:255',
            'email'				=> 'required|email|max:255|unique:Users',
            'password' 			=> 'required|confirmed|min:6',
			'alamat_user' 		=> 'required|max:255',
			'kota_user' 		=> 'required|max:255',
			'country_code_user'	=> 'required|max:3',
			'mobile_phone_user'	=> 'required|max:15',
			'gender'			=> 'required|in:Pria,Wanita',
			'tanggal_lahir' 	=> 'required|date',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    public function generateCode($length) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$code = '';
		for ($i = 0; $i < $length; $i++) {
			$code .= $characters[rand(0, $charactersLength - 1)];
		}
		return $code;
	}
 
    
    protected function create(array $data)
    {
        return Users::create([
			'nama_user' 			=> $data['nama_user'],
            'email' 				=> $data['email'],
            'password' 				=> bcrypt($data['password']),
			'alamat_user' 			=> $data['alamat_user'],
			'kota_user' 			=> $data['kota_user'],
			'country_code_user' 	=> $data['country_code_user'],
			'mobile_phone_user' 	=> $data['mobile_phone_user'],
			'gender' 				=> $data['gender'],
			'tanggal_lahir' 		=> $data['tanggal_lahir'],
			'total_point_resto'		=> 0,
			'verified' 				=> 0,
			'saldo'					=> 0,
			'verify_sms'			=> $this->generateCode(5),
			'verify_email'			=> $this->generateCode(5)
        ]);
    }
}
