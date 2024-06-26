<?php

namespace App\Http\Controllers;

use App\Mail\Mail;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Hash;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Models\PasswordReset;

class AuthController extends Controller
{

    public function signin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = $request->only('email', 'password');
        $remember_me = $request->has('remember_me');
        $login= Auth::attempt($user,$remember_me);

        if( $login){
            $user = Auth::user();
            if(count($user->roles) > 1 ){

                return redirect()->route('admin.join');
            }

            else{

                $active_role = $user->roles->first();

                session()->put('active_role' ,$active_role);

                return redirect()->route('admin.dashboard');
            }
        }
        else{
            $msg = 'Login details are not valid';
            $request->session()->flash('error-msg',$msg);
            return redirect()->route('login');
        }
    }

    public function join() {
        $user = User::find(auth()->id());

        return view('admin.auth.join' , compact('user'));
    }

    public function joinAs( $role) {
        $role = Role::query()->where('slug',$role)->first();
        session()->put('active_role' , $role);
        return redirect()->route('admin.dashboard');
    }

    public function signOut() {
        Session::flush();
        Auth::logout();
        return Redirect()->route('login');
    }

    public function login(){
        return view('admin.auth.login');
    }

    public function passwordForgot(){
        return view('auth.passwords.forgot');
    }

    public function passwordReset(){
        return view('auth.passwords.reset');
    }

    public function passwordResetOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        $chquser = User::query()->where('email', '=', $request->post('email'))->first();
        if($chquser == null){
            $msg ='Email not registered';
            $request->session()->flash('error-msg',$msg);
            return redirect('forgot-password');
        }
       else{
            $chqotp = PasswordReset::query()->where('email', '=', $request->post('email'))->first();
            $random = rand(0000,9999);
            if($chqotp == null){
                $reset = new PasswordReset();
                $reset->email = $request->email;
                $reset->token =  $random;
                $reset->save();
            }else{
                $chqotp->token = $random;
                $chqotp->update();
            }

            $details = [
                'email' => $request->post('email'),
                'otp' => $random,
                'type'=>'otp'
            ];
            $subject=" MyCATKing: Validate OTP for Resetting the Password";

            \Mail::to($request->email)->send(new Mail($details,$subject));

            $msg ='Mail Sent to Your Email';
            $request->session()->flash('success-msg',$msg);
            Session::put('email',$request->email);
            return redirect('reset-password');
       }
    }

    public function newPassword(Request $request)
    {

        $request->validate([
            'otp' => 'required',
            'old_password' => 'required',
            'new_password' => 'required|min:6',
        ]);
        if($request->old_password == $request->new_password){
            $check = passwordReset::query()->where(['email'=>$request->email,'token'=>$request->otp])->first();

            if($check){
                $user = User::query()->where('email',$request->email)->first();
                $user->password = Hash::make($request->new_password);
                $update = $user->update();
                if($update){
                    $msg ='Password Update Successfully';
                    $request->session()->flash('success-msg',$msg);
                    return redirect()->route('login');
                }
            }else{
                $msg ='Otp is Incorrect.';
                $request->session()->flash('error-msg',$msg);
                return redirect('reset-password');
            }
        }else{
            $msg ='password does not match with confirm password';
            $request->session()->flash('error-msg',$msg);
            return redirect('reset-password');
        }
    }

    public function sendOtp(Request $request, $method)
    {
        $sent_to = 'phone'; $phone_number = $email = $phone_code = $user = null;

        switch($method) {
            case 'forgot_password':
                $request->validate([
                    'email' => 'required|exists:users,email'
                ]);
                $user = User::query()->where('email', $request->input('email'))->first();
                $email = $user->email;
                $sent_to = "email";
                break;
        }

        switch($sent_to){
            case "email":
                $channel = "email address";
                break;
            case "phone":
                $channel = "phone number";
                break;
            default:
                $channel = "phone number and email address";
                break;
        }

        if($phone_number || $email){
            $otp = js_get_sms_verification_otp($method, $email, $phone_number, $phone_code, $sent_to);
            $message = __('app.auth.otp_message_text', ['user_name' => $user ? $user->name : 'User', 'otp' => $otp]);

            switch($sent_to){
                case "email":
                    js_send_email(
                        __('app.email_subject.otp_verification'),
                        ['user_name' => $user ? $user->name : 'User', 'otp' => $otp, 'otp_timeout' => __('app.auth.otp_timeout')],
                        $email,
                        'otp-message'
                    );
                    break;
                case "phone":
                    js_send_otp_sms($otp, $phone_number);
                    break;
                default:
                    break;
            }
            return js_response(null, __('app.auth.otp_sent', ['channel' => $channel]));
        }

        return js_response(null, __('app.auth.otp_sent_failed', ['channel' => $channel]), false);
    }
}
