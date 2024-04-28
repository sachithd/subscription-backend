<?php

namespace App\Services;

use App\Enums\SubscriptionUserType;
use App\Repositories\SubscriptionUserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SubscriptionUserService
{
    public function __construct(protected SubscriptionUserRepositoryInterface $repository)
    {
    }

    /**
     * Creates Subscription User Record in the database,
     * Emails the user on successful creation
     * @param array $subscriptionUser
     * @return array subscription_user_id if successful
     */
    public function createSubscriptionUserAndEmail(array $subscriptionUser): array {
        $result = array(
            "error" => false,
            "message" => '',
            "data" => null
        );

        $subscriptionUserId = $this->repository->createSubscriptionUser($subscriptionUser);

        if ($subscriptionUserId > 0) {
            $result['message'] = "subscription user created successfully";
            $result['data'] = array("subscription_user_id" => $subscriptionUserId);
            $newSubscriptionUser = $this->getSubscriptionUserById($subscriptionUserId);

            if (!empty($newSubscriptionUser)) {
                $this->sendEmail($newSubscriptionUser);
            }
        } else {
            $result['error'] = true;
            $result['message'] = "failed to create a subscription user";
        }

        return $result;
    }

    /**
     * Returns the subscription user details by id
     * @param int $subscriptionUserId
     * @return array Subscription User Details
     */
    private function getSubscriptionUserById(int $subscriptionUserId): array
    {
        $subscriptionUser = $this->repository->getSubscriptionUserById($subscriptionUserId);
        if (!is_null($subscriptionUser) && count($subscriptionUser) > 1) {
            return (array)$subscriptionUser[0];
        }

        return array();
    }

    private function sendEmail($newSubscriptionUser): void
    {
        $emailBody = $this->getEmailByUserType($newSubscriptionUser);
        $emailTo = $newSubscriptionUser['email'];
        $subject = "Registration Confirmation";

        try {
            //TODO Improve the email sending to utilize Laravel queue for background sending
            Mail::raw($emailBody, function ($message) use ($emailTo, $subject) {
                $message->to($emailTo)
                    ->subject($subject);
            });
            Log::info("Email sent to $emailTo successfully [$emailBody]");
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
        }

    }

    private function getEmailByUserType($newSubscriptionUser): string
    {
        return match ($newSubscriptionUser['user_type']) {
            SubscriptionUserType::STUDENT->value => "Welcome " . $newSubscriptionUser['user_type'],
            SubscriptionUserType::TEACHER->value => "Hello " . $newSubscriptionUser['user_type'],
            SubscriptionUserType::PARENT->value => "Hi " . $newSubscriptionUser['user_type'],
            SubscriptionUserType::PRIVATE_TUTOR->value => "Hey " . $newSubscriptionUser['user_type'],
            default => "Who are you?",
        };
    }

}
