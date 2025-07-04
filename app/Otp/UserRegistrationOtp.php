<?php

namespace App\Otp;

use App\Models\User;
use App\Models\Dashboard\Contact;
use App\Models\Dashboard\Campaign;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use SadiqSalau\LaravelOtp\Contracts\OtpInterface as Otp;

class UserRegistrationOtp implements Otp
{
    /**
     * Initiates the OTP with user detail
     *
     * @param string $name
     * @param string $email
     * @param string $password
     */
    public function __construct(
        protected string $name,
        protected string $email,
        protected string $password,
        protected string $phone = '',
    ) {
    }

    /**
     * Creates the user
     */
    public function process()
    {
        /** @var User */
        $user = User::unguarded(function () {
            return User::create([
                'name'                  => $this->name,
                'email'                 => $this->email,
                'password'              => Hash::make($this->password),
                'email_verified_at'     => now(),
            ]);
        });
        $role = Role::where('name' , 'User')->first();
        $user->roles()->sync($role);
        event(new Registered($user));
        
        Auth::login($user);

        return [
            'user' => $user
        ];
    }
}