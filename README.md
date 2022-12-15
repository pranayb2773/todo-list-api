
## Todo List API

This is a sample to-do list RESTful API created using Laravel framework. With this API, you can manage your to-do list like view, create, edit and delete functionalities. I have added some other features like Auth where user can login and logout. Laravel Sanctum package is used to create token for users. I have put some access controls to limit sort of operation user can perform.

## Features
- **Users** - Admin user can do all operations on user. Normal user can only view, update his data.
- **Tags** - Any logged-in user can perform all operations on tags.
- **TodoLists** - Admin user can do all operations on todo-lists. Normal user can only view, create, update, delete his todo list data.

## Installation
To install with Docker, run following commands:

```
git clone git@github.com:pranayb2773/todo-list-api.git
cd todo-list-api
cp .env.example .env
```
Change following database credentials in .env file
```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=todo_list_api
DB_USERNAME=sail
DB_PASSWORD=password
```

I have used Laravel Sail package for docker. Installing Composer Dependencies For Existing Applications.
```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```
Configuring A Bash Alias
``` 
alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'

``` 
To start all of the Docker containers in the background, you may start Sail in "detached" mode:
``` 
sail up -d
``` 

Generate a new application key and database migration, data seeding
``` 
sail php artisan key:generate
sail php artisan migrate:fresh --seed
```

## Routes
In ```routes/api.php``` file, contain task related routes.
``` 
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('/users', UserController::class);
    Route::apiResource('/tags', TagController::class);
    Route::apiResource('/users/{user}/todo-lists', UserTodoListController::class);
});
```

In ```routes/web.php``` file, contain api swagger documentation route.
``` 
//I have added swagger documentation page to run test. Otherwise you can find swagger json file in public/swagger/swagger.json
Route::get('/', function () {
    return view('swagger.index');
});
```

## OpenAPI and Postman

- `public/swagger/swagger.json` - This is the OpenAPI json file is for documentation and testing api endpoints.
- `Todo List API.postman_collection.json` - This is the todo list postman api collection file. You can use this file test api in Postman application.

## Folders

- `app/Http/Controllers/v1` - This folder contain all controller files which related to this project
- `app/Http/Requests/v1` - Contains validation rules and error messages details in it.
- `app/Policies/v1` - Contains all policies classes to create access controls for user to limit sort of operations user can perform.
- app/Resources/v1 - Contains all resources for model to transform data we send.
- `app/Models` - Contains all models information.
- `databases/migrations` - Contains the tables schema
- `databases/factories && datases/seeders` - Created factories and seeders to create data for project.
