<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Otp\UserRegistrationOtp;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use SadiqSalau\LaravelOtp\Facades\Otp;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

        public function showRegistrationForm(){
        $local_title = 'Login / Register';
        $local_description = 'Login or Register to use our online features';
        $role = Role::where('name' , 'User')->first()->id;
        return view('auth.register'  , compact('role', 'local_title', 'local_description'));
    }

    public function register(Request $request){
        // dd('register');
        $local_title = 'Login / Register';
        $local_description = 'Login or Register to use our online features';

        $validator = $request->validate([
            'name' => [
                'string',
                'required',
            ],
            'email' => [
                // :rfc,dns
                'required',
                'email',
                'unique:users,email' . (request()->route('user') ? ',' . request()->route('user')->id : ''),
            ],
            'password' => [
                'required',
            ],
            // 'phone' => ['required' ,'digits:10' , Rule::unique('contacts')]
            // 'g-recaptcha-response' => ['required', new ReCaptchaV3('submitContact')],
        ]);

        $otp = Otp::identifier($request->email)->send(
            new UserRegistrationOtp(
                $request->get('name') ?? '',
                $request->get('email') ?? '',
                $request->get('password') ?? '',
            ),
            Notification::route('mail', $request->email)
        );
        session()->flash('info', __('Search For "Your OTP code" in "storage/logs/laravel.log" '));

        return view('auth.emailverificationPage' , ['email' => $request->email, 'local_title' => $local_title, 'local_description' => $local_description]);
    }

    public function otpVerfication(Request $request) {
        $request->validate([
            'email'    => ['required', 'string', 'email', 'max:255'],
            'code'     => ['required', 'string']
        ]);
    
        $otp = Otp::identifier($request->email)->attempt($request->code);
    
        if($otp['status'] != Otp::OTP_PROCESSED)
        {
            if($otp['status'] == 'otp.mismatched'){
                session()->flash('danger', 'Wrong verfication code');
                return view('auth.emailverificationPage' , ['email' => $request->email,]);
            }
            else{
                session()->flash('danger', 'Somthing went wrong please try again!');
                return view('auth.emailverificationPage' , ['email' => $request->email ,]);
            }
        }
        
        return redirect()->route('login')->with('success', __('Your account is verfied. You can login now'));
    }

    public function otpResend(Request $request) {

        $request->validate([
            'email'    => ['required', 'string', 'email', 'max:255']
        ]);
    
        $otp = Otp::identifier($request->email)->update();
    
        if($otp['status'] != Otp::OTP_SENT)
        {
            abort(403, __($otp['status']));
        }
        return __($otp['status']);
    }
}
