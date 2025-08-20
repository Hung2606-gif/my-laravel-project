<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Models\User;
use App\Mail\UserReportMail;
use Illuminate\Support\Facades\Mail;

class SendUserReports extends Command
{
    protected $signature = 'report:send-users';
    protected $description = 'Gửi báo cáo đến  user';

    public function handle()
    {
        $users = User::all();

        foreach ($users as $user) {
            Mail::to($user->email)->send(new UserReportMail($user));
        }

        $this->info('Đã gửi báo cáo đến user.');
    }
}
