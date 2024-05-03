<?php

namespace App\Console\Commands;

use App\Repositories\SubscriptionUserRepository;
use Illuminate\Console\Command;

class RenewalReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:renewal-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $repository = new SubscriptionUserRepository();
        $usersDueForRenewal = $repository->getUsersBySubscriptionEndDate();
        foreach ($usersDueForRenewal as $user) {
            $emailResponse = $this->sendEmail($user->email);
            if($emailResponse){
                $repository->setEmailReminder($user->id, true);
            }
        }
    }

    private function sendEmail($email): true
    {
        return true;
    }
}
