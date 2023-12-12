<?php

namespace App\Console\Commands;

use App\Models\Company;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendAutoMail extends Command
{
    protected $signature = 'send:mails';

    protected $description = 'Send Auto Mails';

    public function handle()
    {
        $currentDate = Carbon::now();

        $companies = Company::whereDate('due_date', '>=', $currentDate)->get();

        foreach ($companies as $key => $company) {
            $user = User::find($company->user_id);

            // Calculate reminder dates
            $reminder15Days = $company->due_date->subDays(15);
            $reminder1Week = $company->due_date->subWeek();
            $reminder24Hours = $company->due_date->subDay();
 

            // Check if the current date is equal to or later than the reminder date
            if ($currentDate->gte($reminder15Days)) {
                // Send 15 days reminder email
                js_email('15 Days Reminder: subject', json_decode($company), $user->email, 'mail');
            }

            if ($currentDate->gte($reminder1Week)) {
                // Send 1 week reminder email
                js_email('1 Week Reminder: subject', json_decode($company), $user->email, 'mail');
            }

            if ($currentDate->gte($reminder24Hours)) {
                // Send 24 hours reminder email
                js_email('24 Hours Reminder: subject', json_decode($company), $user->email, 'mail');
            }

            $this->info('Mail send successfully.');
        }
    }
}
