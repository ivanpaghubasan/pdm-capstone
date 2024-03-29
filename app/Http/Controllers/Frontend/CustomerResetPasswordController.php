<?php

namespace App\Http\Controllers\Frontend;

use App\Models\CompanyDetails;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class CustomerResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/my-account/orders';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:customer');
    }

    public function showResetForm(Request $request, $token = null)
    {

        return view('auth.passwords.reset-customer')->with(
            ['token' => $token, 'email' => $request->email, 'data'=> 'Reset Password','company' => CompanyDetails::first()]
        );
    }

    protected function guard()
    {
        return Auth::guard('customer');
    }

    protected function broker()
    {
        return Password::broker('customers');
    }

    
}
