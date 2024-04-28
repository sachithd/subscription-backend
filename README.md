#

##Instructions    
    
*git clone https://github.com/sachithd/subscription-backend.git
*docker compose up -d
*docker exec -it --user=$USER TwinklTestServer bash
*composer install
*mv .env.example .env
*php artisan key:generate
*php artisan migrate
*php artisan db:seed --class=SubscriptionUserTypeSeeder

##API End Point
*http://localhost:8008/api/subscription_user

##Header
Accept: application/json

##JSON Payload 
{
    "first_name" : "Test",
    "last_name" : " User",
    "email" : "test.user@test.com",
    "user_type_id" : 1
}
