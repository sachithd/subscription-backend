<?php

namespace App\Repositories;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SubscriptionUserRepository implements SubscriptionUserRepositoryInterface
{

    public function createSubscriptionUser(array $data): int
    {
        $id = -1;
        try {
            $id = DB::table('subscription_users')->insertGetId($data);
        } catch (Exception $exception) {
            $this->logException($exception);
        }
        return $id;
    }

    public function getSubscriptionUserById($id): ?Collection
    {
        $data = null;
        try {
            $data = DB::table('subscription_users')
                ->join('subscription_user_types', 'subscription_users.user_type_id', '=', 'subscription_user_types.id')
                ->select(
                    'subscription_users.id as subscription_user_id',
                    'subscription_users.first_name',
                    'subscription_users.last_name',
                    'subscription_users.email',
                    'subscription_users.user_type_id',
                    'subscription_user_types.user_type'
                )
                ->get();
        } catch (Exception $exception) {
            $this->logException($exception);
        }
        return $data;
    }

    public function getUsersBySubscriptionEndDate(): array
    {
        $data = null;
        try {
            $data = DB::select("SELECT * FROM subscription_users
                                      WHERE
                                      CURRENT_DATE = DATE(DATE_ADD(DATE_ADD(subscription_date, INTERVAL 1 YEAR), INTERVAL -1 WEEK))
                                      AND email_reminder = 0");
        } catch (Exception $exception) {
            $this->logException($exception);
        }
        return $data;
    }

    public function setEmailReminder($id, $hasNotified): int
    {
        $rowCount = -1;
        try {
            $rowCount = DB::table('subscription_users')
                ->where('id',$id)
                ->update(
                    array('email_reminder'=>$hasNotified)
                );
        } catch (Exception $exception) {
            $this->logException($exception);
        }

        return $rowCount;
    }

    /**
     * Log Exceptions into the log file.
     * Log Query and Bindings separately for any SQL exceptions
     * @param $e
     * @return void
     */
    private function logException($e): void
    {
        Log::error($e->getMessage());
        if ($e instanceof QueryException) {
            Log::error($e->getSql(), $e->getBindings());
        }
    }


}
