# Rakamin Chat Mini Project

## Installation:
1. Clone this repository
    ```bash
    git clone https://github.com/sizuwanoadi/rakamin-mini-project.git

    cd rakamin-mini-project
    ```

2. Run composer install to install the dependencies
   ```bash
   composer install
   ```

3. Setup Environtment variable file, and setup the database in <code>.env</code> file
   ```bash
   cp .env.example .env
   ```

4. Run the migration with seeder
   ```bash
   php artisan migrate --seed
   ```

5. Generate the application key
   ```bash
   php artisan key:generate
   ```

6. Aplication ready to run, you can run it from artisan serve
   ```bash
   php artisan serve
   ```

## Credentials
- Username / Email : 
andi.adinata / andi.adinata@example.com,
bimo.satria / bimo.satria@example.com,
caca / cacaa@example.com,
jowar / joko@example.com

- Password : 123456

## Postman Doc API
- Via JSON : https://www.getpostman.com/collections/e36e24173f980692cebc
- Via Postman Workspace : https://www.postman.com/planetary-equinox-119920/workspace/rakamin-mini-project/collection/8302287-1452aaba-29c0-4d00-a152-d583b6e7b715

## Route list

| Method    | URI                             |  Action                  | Params                  |
|-----------|---------------------------------|--------------------------| email/username, password|
| POST       | api/login | App\Http\Controllers\AuthController@login  | |
| POST       | api/logout | App\Http\Controllers\AuthController@logout  | |
| POST       | api/refresh | App\Http\Controllers\AuthController@refresh | | 
| POST       | api/me | App\Http\Controllers\AuthController@me  | |
| GET        | api/chat | App\Http\Controllers\ChatController@index  | id (to read chat) |
| POST       | api/chat | App\Http\Controllers\ChatController@store  | user_id (user you want to chat), messages, reply_id (id chat_messages you want to reply) |

