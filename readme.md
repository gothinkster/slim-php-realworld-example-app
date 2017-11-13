# ![RealWorld Example App](logo.png)

> ### Slim codebase containing real world examples (CRUD, auth, advanced patterns, etc) that adheres to the [RealWorld](https://github.com/gothinkster/realworld) spec and API.


### [Demo](https://github.com/gothinkster/realworld)&nbsp;&nbsp;&nbsp;&nbsp;[RealWorld](https://github.com/gothinkster/realworld)


This codebase was created to demonstrate a fully fledged fullstack application built with **[Slim](https://www.slimframework.com/)** including CRUD operations, authentication, routing, pagination, and more.

We've gone to great lengths to adhere to the **Slim** community styleguides & best practices.

For more information on how to this works with other frontends/backends, head over to the [RealWorld](https://github.com/gothinkster/realworld) repo.


# How it works
The basic idea behind this app is to provide a backend web service for the website [Conduit](https://demo.realworld.io/#/)
made by the [Thinkster](https://github.com/gothinkster) team.

It is designed as an api which process requests and returned JSON responses. 

 **tl;dr commands** 
```bash
git clone https://github.com/alhoqbani/slim-php-realworld-example-app.git
cd slim-php-realworld-example-app
composer install
```
> Edit `.env` file with your database configurations. 
```bash
composer refresh-database 
composer start
```
> visit [http://localhost:8080/api/articles](http://localhost:8080/api/articles) from your browser

> **Or follow this detailed guide to install and understand the code**

# Getting Started
## Pre-requisites
Make sure you have php, mysql and composer installed on your machine. 

## Installation
> You should start by cloning the repository into your local machine.
```bash
git clone https://github.com/alhoqbani/slim-php-realworld-example-app.git
cd slim-php-realworld-example-app
```
### Dependencies 
The app is built using **[Slim](https://www.slimframework.com/)**. However, there ara extra packages used by the app must be installed.
> Install Dependencies
```bash
composer install
```
**List of Dependencies**
- [tuupola/slim-jwt-auth](https://appelsiini.net/projects/slim-jwt-auth/) To manage the api authentication using JWT.
- [respect/validation](http://respect.github.io/Validation/) Validate the request parameters.
- [league/fractal](https://fractal.thephpleague.com/) Transfer data models to JSON for the Api responses.
- [illuminate/database](https://laravel.com/docs/5.5/eloquent) Eloquent ORM for ActiveRecord implementation and managing data models
- [robmorgan/phinx](https://phinx.org/) Manage database migration. 
- [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv) To load environment variables from `.env` file.
- [fzaninotto/faker](https://github.com/fzaninotto/Faker) Generate fake data for testing and populating the database.
- [phpunit/phpunit](https://phpunit.de/) Testing Framework.

### Environments Variables
All the app environments variables are stored in the [.env](https://github.com/alhoqbani/slim-php-realworld-example-app/blob/master/.env.example) file.

The command `composer install` will copy .env.example to `.env` which should have your own variables and never shared or committed into git.
> Check the .env file and edit the variables according to your environments. (Database name/user/password).
The `.env` is loaded using `vlucas/phpdotenv` through these [lines of code](https://github.com/alhoqbani/slim-php-realworld-example-app/blob/master/src/settings.php#L3-L11)

# Code Overview
## Directory Structure
> Open the project directory using your favorite editor.

The app follows the structure of [Slim skeleton application](https://github.com/slimphp/Slim-Skeleton) with minor changes.
The skeleton is a good starting point when developing with Slim framework.
A detailed overview of the directory structure can be found at [this page](docs/directory.md).  

## Design Architecture
### Api Design
The api is designed according to the [RealWorld](https://github.com/gothinkster/realworld-example-apps) specifications. 
Make sure to familiarized yourself with all endpoints specified in the [Full API Spec](https://github.com/gothinkster/realworld/tree/master/api)
### Code Design
The code utilizes the MVC pattern where requests are redirected to a controller to process the request and returned a JSON response.
Persistence of data is managed by the models which provide the source of truth and the database status. 
### Data Structure
***Database Schema***

The app is built using a relational database (e.g. MySQL), and consists of 8 tables. 

> Setup the database
> Create a database in MySQL and name it `conduit` or whatever you prefer. 
> Next, don't forget to update (Environments Variables)[#environments-variables] in `.env` file.
Check [Database Documentation](docs/database.md) for details on the schema. 

***Database Migration:***

Database migrations or [Schema migration](https://en.wikipedia.org/wiki/Schema_migration) 
is where the app defines the database structure and blueprints. 
It also holds the history of any changes made to the database schema and provides easy way to rollback changes to older version.

The app database migrations can be found at [the migration directory](database/migrations).
Migrations are performed using [Phinx](https://phinx.org/).
> Migrate the Database
To create all the tables using migration run the following command from the project directory.
```bash
php vendor/bin/phinx migrate
```

***Data Models***

The data is managed by models which represent the business entities of the app. There are four models `User`, `Article`, `Comment`, and `Tag`. 
They can be found at [Models Directory](src/Conduit/Models). Each model has corresponding table in the database. 

Relationships with other models are defined by each model using Eloquent ORM.
For example, `User-Comment` is a one-to-many relationship 
which is defined [by the User model](https://github.com/alhoqbani/slim-php-realworld-example-app/blob/51ef4cba018673ba63ec2f8cb210effff26aaec5/src/Conduit/Models/User.php#L66-L69)
and [by the Comment model](https://github.com/alhoqbani/slim-php-realworld-example-app/blob/51ef4cba018673ba63ec2f8cb210effff26aaec5/src/Conduit/Models/Comment.php#L41-L43).
This relationship is stored in the database by having a foreign key `user_id` in the comments table.

Beside The four tables in the database representing each model, the database has three other tables to store many-to-many relationships (`article_tag`, `user_favorite`, `users_following`).
For example, An article can have many tags, and a tag can be assigned to many articles. This relationship is defined by the 
[Article model](https://github.com/alhoqbani/slim-php-realworld-example-app/blob/51ef4cba018673ba63ec2f8cb210effff26aaec5/src/Conduit/Models/Article.php#L69-L72) 
and the [Tag model](https://github.com/alhoqbani/slim-php-realworld-example-app/blob/51ef4cba018673ba63ec2f8cb210effff26aaec5/src/Conduit/Models/Tag.php#L31-L34),
and is stored in the table `article_tag` which .

***Data Seeding***
To populate the database with data for testing and experimenting with the code. Run:
```bash
php vendor/bin/phinx migrate
```
To edit how the data is seeded check the file: [DataSeeder](database/seeds/DataSeeder.php).

> The command `composer refresh-database` will run a rollback all migrations, migrate the database and seed the data.
> (Note: all data will be lost from the database) 

## The Slim Application
> Start the app by running the following command:
```bash
composer start
```
This command will spin a local php server which is enough for testing.
You can check the api by visiting [http://localhost:8080/api/articles](http://localhost:8080/api/articles)
### Entry Point:

## Request-Response Cycle
All requests go through the same cycle:  `routing > middleware > conroller > response`
### Routes:
> Check the list of endpoints defined by the [RealWorld API Spec](https://github.com/gothinkster/realworld/tree/master/api#endpoints)
All the app routes are defined in the [routes.php](src/routes.php) file.

The Slim `$app` variable is responsible for registering the routes. 
You will notice that all routes and enclosed in the `group` method which gives the prefix api to all routes: `http::/localhost/api`

Every route is defined by method correspond to HTTP verb. For example, a post requests to register a user is defined by:
```php
    $this->post('/users', RegisterController::class . ':register')->setName('auth.register');
```
> Notice: we use `$this` because where inside a closure that is bound to `$app`; 

The method, `post()`, defines `/api/users` endpoint and direct the request to method `register` on `RegisterController` class.

### Middleware
In a Slim app, you can add middleware to all incoming routes, to specific route, or to group of routes. [Check the documentations](https://www.slimframework.com/docs/concepts/middleware.html) 

In this app we add some middleware to specific routes. For example, to access `/api/articles` POST endpoint, the request will go through `$jwtMiddleware`
```php
    $this->post('/articles', ArticleController::class . ':store')->add($jwtMiddleware)->setName('article.store');
```
> see [Authentication](#authentication) for details

Also, We add some global middleware to apply to all requests in [middleware.php](src/middleware.php).
[CORS Middleware](https://github.com/alhoqbani/slim-php-realworld-example-app/blob/51ef4cba018673ba63ec2f8cb210effff26aaec5/src/middleware.php#L9-L16)
for example.
> see [CORS](#cors) for details

### Controllers
After passing through all assigned middlewares, the request will be processed by a controller.
> Note: You could process the request inside a closure passed as the second argument to the method defining the route.
> For example, (the last route)[https://github.com/alhoqbani/slim-php-realworld-example-app/blob/51ef4cba018673ba63ec2f8cb210effff26aaec5/src/routes.php#L88-L95],
which is left from the skeleton project, handles the request in a closure
> [Check the documentations](https://www.slimframework.com/docs/objects/router.html#route-callbacks).

The controller's is to validate the request data, check for authorization, process the request by calling a model or do other jobs, 
and eventually return a response in the form JSON response. 
> TODO: Explain further

# Test
`composer test`
