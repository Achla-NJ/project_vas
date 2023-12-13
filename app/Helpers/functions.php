<?php
use App\Models\Activity;
use App\Jobs\SendEmail;
use App\Models\User;
use App\Mail\CompanyMail;

if (!function_exists('js_activity_log')) {
    function js_activity_log($user_id ,  $model , $operation , $model_id ,  $role_id =NULL,$updation =NULL)
    {
        Activity::create([
            'user_id' => $user_id,
            'role_id' => $role_id,
            'model' => $model,
            'operation' => $operation,
            'model_id' => $model_id,
            'updation' => $updation
        ]);
    }
}


function js_get_sms_verification_otp($method, $email, $phone_number, $phone_code, $sent_to) {
    $table = "otp_verifications";
    $otp = mt_rand(1000, 9999);
    if($otp == config('whispering-shouts.default_sms_otp')){
        $otp = mt_rand(1000, 9999);
    }

    $data = \Illuminate\Support\Facades\DB::table($table)
        ->select("phone_number")
        ->where("email_address", $email)
        ->where("phone_number", $phone_number)
        ->where("phone_code", $phone_code)
        ->where("method", $method)
        ->where("sent_to", $sent_to)
        ->first();

    if($data) {
        \Illuminate\Support\Facades\DB::table($table)
            ->where("email_address", $email)
            ->where("phone_number", $phone_number)
            ->where("phone_code", $phone_code)
            ->where("method", $method)
            ->where("sent_to", $sent_to)
            ->update([
                "otp" => $otp,
                "verified" => "no",
                "updated_at" => Carbon::now(),
            ]);
    }else{
        \Illuminate\Support\Facades\DB::table($table)
            ->insert([
                "email_address" => $email,
                "phone_number" => $phone_number,
                "phone_code" => $phone_code,
                "otp" => $otp,
                "verified" => "no",
                "method" => $method,
                "sent_to" => $sent_to,
                "created_at" =>  Carbon::now(),
                "updated_at" => Carbon::now(),
            ]);
    }
    return $otp;
}

function js_sms_verification($method, $email, $phone_number, $phone_code, $sent_to, $otp, $only_check = false): bool {
    if($otp == config('project.default_otp')){
        return true;
    }
    $table = 'otp_verifications';
    $date = new \DateTime;
    $date->modify('-30 minutes');
    $formatted_date = $date->format('Y-m-d H:i:s');

    // dd(func_get_args());

    // DB::enableQueryLog();
    $data = \Illuminate\Support\Facades\DB::table($table)->select('otp');

    if($sent_to == "both"){
        $data->where(function ($query) use ($email, $phone_number) {
            $query->where('phone_number', $phone_number);
            $query->orWhere('email_address', $email);
        });
    }else{
        if($phone_number){
            $data->where('phone_number', $phone_number);
        }else{
            $data->whereNull('phone_number');
        }
        if($phone_code){
            $data->where('phone_code', $phone_code);
        }else{
            $data->whereNull('phone_code');
        }
        if($email){
            $data->where('email_address', $email);
        }else{
            $data->whereNull('email_address');
        }
    }

    $data->where('method', $method)
        ->where('otp', $otp)
        ->where('sent_to', $sent_to)
        ->where('verified', 'no')
        ->where('updated_at', '>=', $formatted_date);
    $db_otp = $data->first();
    // dd(DB::getQueryLog(), $db_otp);
    if($db_otp && !$only_check){
        $data->update([
            'verified' => 'yes'
        ]);
    }
    return @$db_otp->otp == $otp;
}

function js_send_otp_sms($otp, $phone_number, $phone_code = "+91"){
    $phone_number = js_add_country_phone_code($phone_number, $phone_code);
     return \Illuminate\Support\Facades\Http::withHeaders([
         'Authkey' => config('project.api.msg91.sms.auth_key'),
         'accept' => 'application/json',
         'content-type' => 'application/json',
     ])->post(config('project.api.msg91.sms.endpoint'), [
         "template_id" => config('project.api.msg91.sms.otp_template_id'),
         "sender" => config('project.api.msg91.sms.sender'),
         "short_url" => "0",
         "mobiles" => $phone_number,
         "var" => $otp,
     ])->json();
     //Foxsms_sendSMS($phone_number, $message);
}

function js_send_email($subject, $data, $email, $view = 'general', DateTimeInterface $schedule = null){
    $details = [
        'subject' => $subject,
        'data' => $data,
        'email' => $email,
        'view' => $view,
    ];

    if($schedule){
        return SendEmail::dispatch($details)->delay($schedule);
    }else{
        return SendEmail::dispatchSync($details);
    }
}

if(!function_exists("js_email")) {
    function js_email($subject, $data, $email, $view  , $files = []) { 
        return \Mail::to($email)->send(new CompanyMail($data,$subject , $view ,$files));
    }
}

if(!function_exists("profile")) {
    function profile() { 
        $user = User::find(auth()->id());
        if(!empty($user->file)){
            return asset('storage/'.$user->file);
        }else{
            return asset('assets/images/default_user.png');
        }
    }
}

function js_active_role_id(){
    if(session()->has('active_role')){
        return session()->get('active_role')['id'];
    }   
}