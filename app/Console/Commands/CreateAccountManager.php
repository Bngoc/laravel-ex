<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use \App\Models\AppModel;
use \App\Models\User;
use \app\Console\Commands\Hash;
use PhpParser\Node\Stmt\Echo_;

class CreateAccountManager extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CreateAccountManager {userName} {--s}';

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
        $user = new User();
        $user->username = $userN = strtolower($this->argument('userName'));
//        if (empty($userN)) {
//            $this->info('--------------------------------------------');
//            echo $this->error('Input userName a account');
//            $this->info('--------------------------------------------');
//            exit();
//        }

        if ($this->option('s')) {

            $isCheckCount = User::where('level', \App\Models\AppModel::ACCESS_SUPERADMIN_ACTION);
            if ($isCheckCount->count() > 1) {
                $this->info('--------------------------------------------');
                echo $this->error('UserName not use');
                $this->info('--------------------------------------------');
                exit();
            } elseif ($isCheckCount->count() == 0) {
                // redrice create acc\
                $pwdCreate = $this->secret('What is the password?');
                if (strlen($pwdCreate) < 6) {
                    $this->comment('--------------------------------------------');
                    //$this->call('CreateAccountManager', ['userName' => $userN, '--s' => '--s']);
                    exit($this->error('Error -> Password lengh min 6 character!'));
                }
                $pwdCreateClone = $this->secret('Confirm password?');

                if ($pwdCreateClone !== $pwdCreate) {
                    $this->info('--------------------------------------------');
                    echo $this->error('Error -> Confirmation password do not match');
                    $this->info('--------------------------------------------');
                    exit();
                }
                $user->email = $email = $this->ask("What is the email?");
                $user->level = $aclLevel = \App\Models\AppModel::ACCESS_SUPERADMIN_ACTION;
                $user->password = \Hash::make($pwdCreateClone);
                $user->save();
            } else {
                $this->info('--------------------------------------------');
                echo $this->info('Info -> Run not task');
                $this->info('--------------------------------------------');
                exit();
            }
        } else {

        }
//        if ($optAcl == 's') {
//            $isAtc = true;
//            $levelAcl = \App\Models\AppModel::ACCESS_SUPERADMIN_ACTION;
//        } elseif ($optAcl == 'a') {
//            $levelAcl = \App\Models\AppModel::ACCESS_ADMIN_ACTION;
//        } else {
//            $levelAcl = \App\Models\AppModel::ACCESS_MEMBER_ACTION;
//        }

//        if ($isAtc) {

//        } else {
//            $this->info('--------------------------------------------');
//        }

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
