<?php

namespace App\Http\Controllers\Frontend;

use App\Models\CompanyDetails;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;


class CustomerForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;
    
    protected $broker = 'customers'; 
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:customer');
    }

    public function showLinkRequestForm()
    {
        $company = CompanyDetails::first();
        $data = 'Forgot Password'; 
        return view('auth.passwords.email-customer', compact('data','company'));
    }

    protected function broker()
    {
        return Password::broker('customers');
    }

    
}
