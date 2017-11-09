# ![RealWorld Example App](logo.png)

> ### Slim codebase containing real world examples (CRUD, auth, advanced patterns, etc) that adheres to the [RealWorld](https://github.com/gothinkster/realworld) spec and API.


### [Demo](https://github.com/gothinkster/realworld)&nbsp;&nbsp;&nbsp;&nbsp;[RealWorld](https://github.com/gothinkster/realworld)


This codebase was created to demonstrate a fully fledged fullstack application built with **[Slim](https://www.slimframework.com/)** including CRUD operations, authentication, routing, pagination, and more.

We've gone to great lengths to adhere to the **Slim** community styleguides & best practices.

For more information on how to this works with other frontends/backends, head over to the [RealWorld](https://github.com/gothinkster/realworld) repo.


# How it works

> Describe the general architecture of your app here

# Getting started
Make sure you have php, mysql and composer installed on your machine. 
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


# Test
`composer test`
