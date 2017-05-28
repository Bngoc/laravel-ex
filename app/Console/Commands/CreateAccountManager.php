<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use \App\Models\AppModel;
use \App\Models\User;

class CreateAccountManager extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CreateAccountManager';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        set_time_limit(300);
        $isCheckCount = User::where('level', 1);

         if ($isCheckCount->count() == 0) {
             // redrice create acc
             echo $this->info('----- oj');
         }
         if ($isCheckCount->count() > 1) {
             $uers = $isCheckCount->get();
             $this->info('--------------------------------------------');
             echo $this->error('Account exists in database');
             $this->info('--------------------------------------------');
//             dd($uers);
         }

        $timeCurrent = date('Y-m-d H:i:s', time());
        $timePrevious = date('Y-m-d H:i:s', strtotime('-1 days', time()));
        $timeNext = date('Y-m-d H:i:s', strtotime('+1 days', time()));
//        $userRegisters = User::where('status', User::STATUS_TEMPORARY_MEMBERS)
//            ->whereNotNull('register_token')
//            ->where('register_token_expire', '>=', $timeCurrent)
//            ->where('mail_reminder_time', '>=', $timePrevious)
//            ->where('register_token_expire', '<=', $timeNext)
//            ->get()->toArray();
//
//
//        if (!empty($userRegisters)) {
//            foreach ($userRegisters as $user) {
//                $currentTimeCheck = date('Y-m-d H:i:s', strtotime("-6 hours", time()));
//
//                if ($currentTimeCheck >= $user['mail_reminder_time']) {
//
//                    //send mail
//                    if ($this->sendMailReminder($user)) {
//                        echo $this->info("The email has sent to " . $user['email']);
//                        User::where('id', $user['id'])->update(['mail_reminder_time' => date('Y-m-d H:i:s', time())]);
//                    }
//
//                }
//            }
//        }
    }

    private function sendMailReminder($userData)
    {
//        DB::beginTransaction();
//        $userData['company_name'] = Company::whereId($userData['company_id'])->lists('name')->first();
//        $userData['email_register'] = $userData['email'];
//        //Send email
//        Mail::send('email.welcome', $userData, function ($message) use ($userData) {
//            $message->from('drugtest@ominext.com', '薬局パレットライン/' . $userData['company_name'] . 'ドラッグ');
//            $message->to($userData['email'], 'Hello user')->subject('【薬局パレットライン/' . $userData['company_name'] . 'ドラッグ】会員登録');
//        });
//
//        if (Mail::failures()) {
//            DB::rollBack();
//
//            return false;
//        }
//
//        DB::commit();
//
//        return true;
    }
}
