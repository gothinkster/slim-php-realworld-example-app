# ![RealWorld Example App](logo.png)

> ### Slim codebase containing real world examples (CRUD, auth, advanced patterns, etc) that adheres to the [RealWorld](https://github.com/gothinkster/realworld) spec and API.


### [Demo](https://github.com/gothinkster/realworld)&nbsp;&nbsp;&nbsp;&nbsp;[RealWorld](https://github.com/gothinkster/realworld)


This codebase was created to demonstrate a fully fledged fullstack application built with **[Slim](https://www.slimframework.com/)** including CRUD operations, authentication, routing, pagination, and more.

We've gone to great lengths to adhere to the **Slim** community styleguides & best practices.

For more information on how to this works with other frontends/backends, head over to the [RealWorld](https://github.com/gothinkster/realworld) repo.

* [How it works](#how-it-works)
* [Getting Started](#getting-started)
  * [Pre-requisites](#pre-requisites)
  * [Installation](#installation)
     * [Dependencies](#dependencies)
     * [Environments Variables](#environments-variables)
* [Code Overview](#code-overview)
  * [Directory Structure](#directory-structure)
  * [Design Architecture](#design-architecture)
     * [Api Design](#api-design)
     * [Code Design](#code-design)
     * [Data Structure](#data-structure)
  * [The Slim Application](#the-slim-application)
     * [Entry Point:](#entry-point)
     * [The App Instance](#the-app-instance)
     * [Container Dependencies and Services](#container-dependencies-and-services)
        * [Service Providers](#service-providers)
  * [Request-Response Cycle](#request-response-cycle)
     * [Routes:](#routes)
     * [Middleware](#middleware)
     * [Controllers](#controllers)
* [Authentication and Security](#authentication-and-security)
  * [Authentication (JWT)](#authentication-jwt)
     * [Basic Idea](#basic-idea)
     * [Generating The Token](#generating-the-token)
     * [JWT Verification](#jwt-verification)
     * [Optional Routes](#optional-routes)
  * [Authorization](#authorization)
  * [Security](#security)
     * [CORS](#cors)
* [Test](#test)


# How it works
The basic idea behind this app is to provide a backend web service for the website [Conduit](https://demo.realworld.io/#/)
made by the [Thinkster](https://github.com/gothinkster) team.

It is designed as an api which process requests and return JSON responses. 

 **tl;dr commands** 
```bash
git clone https://github.com/gothinkster/slim-php-realworld-example-app.git
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
git clone https://github.com/gothinkster/slim-php-realworld-example-app.git
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
All the app environments variables are stored in the [.env](https://github.com/gothinkster/slim-php-realworld-example-app/blob/master/.env.example) file.

The command `composer install` will copy .env.example to `.env` which should have your own variables and never shared or committed into git.
> Check the .env file and edit the variables according to your environments. (Database name/user/password).
The `.env` is loaded using `vlucas/phpdotenv` through these [lines of code](https://github.com/gothinkster/slim-php-realworld-example-app/blob/master/src/settings.php#L3-L11)

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
> Next, don't forget to update [Environments Variables](#environments-variables) in `.env` file.
> Check [Database Documentation](docs/database.md) for details on the schema. 

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
These models extends `Illuminate\Database\Eloquent\Model` which provides the ORM implementations.

Relationships with other models are defined by each model using Eloquent.
For example, `User-Comment` is a one-to-many relationship 
which is defined [by the User model](https://github.com/gothinkster/slim-php-realworld-example-app/blob/c826cb831e2de6292f1feb5a1ba3584221f40795/src/Conduit/Models/User.php#L66-L69)
and [by the Comment model](https://github.com/gothinkster/slim-php-realworld-example-app/blob/c826cb831e2de6292f1feb5a1ba3584221f40795/src/Conduit/Models/Comment.php#L41-L43).
This relationship is stored in the database by having a foreign key `user_id` in the comments table.

Beside The four tables in the database representing each model, the database has three other tables to store many-to-many relationships (`article_tag`, `user_favorite`, `users_following`).
For example, An article can have many tags, and a tag can be assigned to many articles. This relationship is defined by the 
[Article model](https://github.com/gothinkster/slim-php-realworld-example-app/blob/c826cb831e2de6292f1feb5a1ba3584221f40795/src/Conduit/Models/Article.php#L69-L72) 
and the [Tag model](https://github.com/gothinkster/slim-php-realworld-example-app/blob/c826cb831e2de6292f1feb5a1ba3584221f40795/src/Conduit/Models/Tag.php#L31-L34),
and is stored in the table `article_tag`.

***Data Seeding***
To populate the database with data for testing and experimenting with the code. Run:
```bash
php vendor/bin/phinx migrate
php vendor/bin/phinx seed:run
```
To edit how the data is seeded check the file: [DataSeeder](database/seeds/DataSeeder.php).

> The command `composer refresh-database` will rollback all migrations, migrate the database and seed the data.
> (Note: all data will be lost from the database) 

## The Slim Application
> Start the app by running the following command:
```bash
composer start
```
This command will spin a local php server which is enough for testing.
You can check the api by visiting [http://localhost:8080/api/articles](http://localhost:8080/api/articles)

> To check all endpoints you need an HTTP client e.g [Postman](https://www.getpostman.com/).
> There is Postman [collection made by Thinkster](https://github.com/gothinkster/realworld/blob/master/api/Conduit.postman_collection.json) team you could use.
### Entry Point:
The server will direct all requests to [index.php](public/index.php). 
There, we boot the app by creating an instance of Slim\App and require all the settings and relevant files.

Finally, we run the app by calling `$app->run()`, which will process the request and send the response.
> We include four important files into the index.php: `settings.php`, `dependencies.php`, `middleware.php`, `routes.php`
> I's a good idea to check them before continuing. 

### The App Instance
The instance of Slim\App (`$app`) holds the app settings, routes, and dependencies.

We register routes and methods by calling methods on the `$app` instance. 

More importantly, the `$app` instance has the `Container` which register the app dependencies to be passed later to the controllers.

### Container Dependencies and Services
In different parts of the application we need to use other classes and services. These classes and services also depends on other classes.
Managing these dependencies becomes easier when we have a container to hold them. Basically, we configure these classes and store them in the container.
Later, when we need a service or a class we ask the container, and it will instantiate the class based on our configuration and return it.

The container is configured in the [dependencies.php](src/dependencies.php).
We start be retrieving the container from the `$app` instance and configure the required services: 
```php
    $container = $app->getContainer();
    
    $container['logger'] = function ($c) {
        $settings = $c->get('settings')['logger'];
        $logger = new Monolog\Logger($settings['name']);
        $logger->pushProcessor(new Monolog\Processor\UidProcessor());
        $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    
        return $logger;
    };
```
The above code registers a configured instance of the `logger` in the container. Later we can ask for the `logger`
```php
    $logger = $container->get('logger');
    $logger->info('log message');
```

We register two middleware with the container:
> We will see them in action later in the [Authentication](#authentication-jwt) section.
```php
    // Jwt Middleware
    $container['jwt'] = function ($c) {
    
        $jws_settings = $c->get('settings')['jwt'];
    
        return new \Slim\Middleware\JwtAuthentication($jws_settings);
    };
    
    // Optional Auth Middleware
    $container['optionalAuth'] = function ($c) {
      return new OptionalAuth($c);
    };
``` 

#### Service Providers
The above services example will not be instantiated until we call for them.
However, we could use a service provider to have some services available without retrieving them from the container.

Our app use Eloquent ORM to handle our data models. Eloquent must be configured and booted. 
We do this in the [EloquentServiceProvider](src/Conduit/Services/Database/EloquentServiceProvider.php) class,
and register the service provider with the container.
```php
    $container->register(new \Conduit\Services\Database\EloquentServiceProvider());
```
For more details check [Dependency Container](https://www.slimframework.com/docs/concepts/di.html) documentations.


## Request-Response Cycle
All requests go through the same cycle:  `routing > middleware > conroller > response`
### Routes:
> Check the list of endpoints defined by the [RealWorld API Spec](https://github.com/gothinkster/realworld/tree/master/api#endpoints)

All the app routes are defined in the [routes.php](src/routes.php) file.

The Slim `$app` variable is responsible for registering the routes. 
You will notice that all routes are enclosed in the `group` method which gives the prefix api to all routes: `http::/localhost/api`

Every route is defined by a method corresponds to the HTTP verb. For example, a post request to register a user is defined by:
```php
    $this->post('/users', RegisterController::class . ':register')->setName('auth.register');
```
> Notice: we use `$this` because where are inside a closure that is bound to `$app`; 

The method, `post()`, defines `/api/users` endpoint and direct the request to method `register` on `RegisterController` class.

### Middleware
In a Slim app, you can add middleware to all incoming routes, to a specific route, or to a group of routes. [Check the documentations](https://www.slimframework.com/docs/concepts/middleware.html) 

In this app we add some middleware to specific routes. For example, to access `/api/articles` POST endpoint, the request will go through `$jwtMiddleware`
```php
    $this->post('/articles', ArticleController::class . ':store')->add($jwtMiddleware)->setName('article.store');
```
> see [Authentication](#authentication-jwt) for details

Also, We add some global middleware to apply to all requests in [middleware.php](src/middleware.php).
[CORS Middleware](https://github.com/gothinkster/slim-php-realworld-example-app/blob/c826cb831e2de6292f1feb5a1ba3584221f40795/src/middleware.php#L9-L23)
for example.
> see [CORS](#cors) for details

### Controllers
After passing through all assigned middleware, the request will be processed by a controller.
> Note: You could process the request inside a closure passed as the second argument to the method defining the route.
> For example, [the last route](https://github.com/gothinkster/slim-php-realworld-example-app/blob/c826cb831e2de6292f1feb5a1ba3584221f40795/src/routes.php#L88-L95),
which is left as an example from the skeleton project, handles the request in a closure
> [Check the documentations](https://www.slimframework.com/docs/objects/router.html#route-callbacks).

The controller's job is to validate the request data, check for authorization, process the request by calling a model or do other jobs, 
and eventually return a response in the form of JSON response. 
> // TODO : Explain how dependencies are injected to the controller.


# Authentication and Security
## Authentication (JWT)
The api routes can be open to the public without authentication e.g [Get Article](https://github.com/gothinkster/realworld/tree/master/api#get-article).
Some routes must be authenticated before being processed e.g [Follow user](https://github.com/gothinkster/realworld/tree/master/api#follow-user).  
Other routes require optional authentication and can be submitted without authentication. 
However, when the request has a `Token`, the request must be authenticated.
This will make a difference in that the request's user identity will be know when we have an authenticated user, and the response must reflect that. 
For example, the [Get Profile](https://github.com/gothinkster/realworld/tree/master/api#get-profile)
endpoint has an optional authentication. The response will be a profile of a user, 
and the value of `following` in the response will depend on whether we have a`Token` in the request.

### Basic Idea
Unlike traditional web application, when designing a RESTful Api, when don't have a session to authenticate.
On popular way to authenticate api requests is by using [JWT](https://jwt.io/).

The basic workflow of *JWT* is that our application will generate a token and send it with the response when the user sign up
or login. The user will keep this token and send it back with any subsequent requests to authenticate his request. 
The generated token will have header, payload, and a signature.
It also should have an expiration time and other data to identify the subject/user of the token. 
For more details, the [JWT Introduction](https://jwt.io/introduction/) is a good resource.

> Dealing with *JWT* is twofold: 
> - Generate a *JWT* and send to the user when he sign up or login using his email/password.  
> - Verify the validity of *JWT* submitted with any subsequent requests.

### Generating The Token
We generate the Token when the user sign up or login using his email/password.
This is done in the [RegisterController](https://github.com/gothinkster/slim-php-realworld-example-app/blob/c826cb831e2de6292f1feb5a1ba3584221f40795/src/Conduit/Controllers/Auth/RegisterController.php#L55)
and [LoginController](https://github.com/gothinkster/slim-php-realworld-example-app/blob/c826cb831e2de6292f1feb5a1ba3584221f40795/src/Conduit/Controllers/Auth/RegisterController.php#L55)
by the [Auth service class](https://github.com/gothinkster/slim-php-realworld-example-app/blob/c826cb831e2de6292f1feb5a1ba3584221f40795/src/Conduit/Services/Auth/Auth.php#L47-L64).
> Review [Container Dependencies](#container-dependencies-and-services) about the auth service.

Finally, we send the token with the response back to the user/client.

### JWT Verification
To verify the *JWT* Token we are using [tuupola/slim-jwt-auth](https://appelsiini.net/projects/slim-jwt-auth/) library.
The library provides a middleware to add to the protected routes. The documentations suggest adding the middleware to app globally
and define the protected routes. However, in this app, we are taking slightly different approach.

We add a configured instance of the middleware to the Container, and then add the middleware to every protected route individually.
> Review [Container Dependencies](#container-dependencies-and-services) about registering the middleware.

In the [routes.php](https://github.com/gothinkster/slim-php-realworld-example-app/blob/c826cb831e2de6292f1feb5a1ba3584221f40795/src/routes.php#L19) file,
we resolve the middleware out of the container and assign to the variable `$jwtMiddleware`

Then, when defining the protected route, we add the middleware using the `add` method:
```php
        $jwtMiddleware = $this->getContainer()->get('jwt');
        $this->post('/articles', ArticleController::class . ':store')->add($jwtMiddleware)
```
The rest is on the `tuupola/slim-jwt-auth` to verify the token.
If the token is invalid or not provided, a 401 response will be returned.
Otherwise, the request will be passed to the controller for processing.

### Optional Routes
For the optional authentication, we create a custom middleware [OptionalAuth](src/Conduit/Middleware/OptionalAuth.php).
The middleware will check if there a token present in the request header, it will invoke the jwt middleware to verify the token. 

Again, we use the OptionalAuth middleware by store it in Container and retrieve it to add to the optional routes.
```php
        $optionalAuth = $this->getContainer()->get('optionalAuth');
        $this->get('/articles/feed', ArticleController::class . ':index')->add($optionalAuth);
```

## Authorization
Some routes required authorization to verify that user is authorized to submit the request.
For example, when a user wants to edit an article, we need to verify that he is the owner of the article.

The authorization is handled by the controller. Simply, the controller will compare the article's user_id with request's user id.
If not authorized, the controller will return a 403 response.
```php
        if ($requestUser->id != $article->user_id) {
            return $response->withJson(['message' => 'Forbidden'], 403);
        }
```
However, in a bigger application you might want to implement more robust authorization system.

## Security
### CORS
[CORS](https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS) is used when the request is coming from a different host.
By default, web browsers will prevent such requests.
The browser will start by sending an `OPTION` request to the server to get the approval and then send the actual request.

Therefor, we handle cross-origin HTTP requests by making two changes to our app:
- Allow `OPTIONS` requests.  
- Return the approval in the response. 

This is done in the by adding two middleware in the [middleware.php](https://github.com/gothinkster/slim-php-realworld-example-app/blob/c826cb831e2de6292f1feb5a1ba3584221f40795/src/middleware.php) file
The first middleware will add the required headers for CORS approval.
And the second, deals with issue of redirect when the route ends with a slash.

For more information check Slim documentations:
- [Setting up CORS](https://www.slimframework.com/docs/cookbook/enable-cors.html)
- [Trailing / in route patterns](https://www.slimframework.com/docs/cookbook/route-patterns.html)

# Test
`composer test`
