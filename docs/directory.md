
# Directory Structure
## App Code
Most of the app code resides in `src/Conduit`
The namespace for autoloading is defined in 
[composer.json](https://github.com/alhoqbani/slim-php-realworld-example-app/blob/51ef4cba018673ba63ec2f8cb210effff26aaec5/composer.json#L30-L34).

```
src/Conduit
├── Controllers # Process the requests.
│   ├── Article # Article related endpoints
│   │   ├── ArticleController.php
│   │   ├── CommentController.php
│   │   └── FavoriteController.php
│   ├── Auth # Authentication related endpoints
│   │   ├── LoginController.php
│   │   └── RegisterController.php
│   ├── BaseController.php
│   └── User # User/Profile related endpoints
│       ├── ProfileController.php
│       └── UserController.php
├── Exceptions # Mainly to handle ModelNotFoundException and return 404 response.
│   └── ErrorHandler.php 
├── Middleware # Custom middlewares should be defined here.
│   └── OptionalAuth.php # Middleware for optional routes when the reqest has token.
├── Models
│   ├── Article.php
│   ├── Comment.php
│   ├── Tag.php
│   └── User.php
├── Services
│   ├── Auth
│   │   ├── Auth.php # Generate JWT Token and retrieve request user
│   │   └── AuthServiceProvider.php
│   └── Database
│       └── EloquentServiceProvider.php
├── Transformers # Transform Models into JSON for response
│   ├── ArticleTransformer.php
│   ├── AuthorTransformer.php
│   ├── CommentTransformer.php
│   └── UserTransformer.php
└── Validation # Validate request endpoint
    ├── Exceptions # Required for Custom Rules
    │   ├── EmailAvailableException.php
    │   ├── ExistsInTableException.php
    │   ├── ExistsWhenUpdateException.php
    │   └── MatchesPasswordException.php
    ├── Rules # Custom Rules
    │   ├── EmailAvailable.php
    │   ├── ExistsInTable.php
    │   ├── ExistsWhenUpdate.php
    │   └── MatchesPassword.php
    └── Validator.php # Main validation class

14 directories, 30 files
```

```
.
├── database # Database schema and seeders
│   ├── factories
│   ├── generator
│   ├── migrations
│   ├── seeds
│   └── BaseSeeder.php
├── logs
│   └── README.md
├── public
│   └── index.php
├── src # The App Code
│   ├── Conduit
│   ├── dependencies.php
│   ├── middleware.php
│   ├── routes.php
│   └── settings.php
├── templates
│   └── index.phtml
├── tests
│   ├── Functional
│   ├── Unit
│   ├── BaseTestCase.php
│   └── UseDatabaseTrait.php
├── vendor
│   ├── bin
│   ├── composer
│   | .
│   | .
│   ├── slim
│   └── autoload.php
├── composer.json
├── logo.png
├── phinx.php
├── phpunit.xml
└── readme.md
41 directories, 24 files
```
