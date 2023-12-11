<?php

namespace App\Console\Commands;

use App\Models\Company;
use App\Models\User;
use Corcel\Model\Taxonomy;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class SendAutoMail extends Command
{
    protected $signature = 'send:mails';

    protected $description = 'Send Auto Mails';

    public function handle()
    {
        $currentDate = Carbon::now();

        $companies = Company::whereDate('due_date', '=', $currentDate)->get();

        foreach ($companies as $key => $company) {
            $user = User::find($company->user_id); 
            js_email('subject', json_decode($company), $user->email, 'mail'); 
        }
        
        

        // Mail::to($user->email)->send(new CompanyMail($data,'Thank you for your Inquiry' , 'mail' , $files ?? []));
 

        
        $this->info('Permission routes added successfully.');
    }
}
