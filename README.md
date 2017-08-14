# Laravel Recipe
Generator framework for Laravel built on Laravel.

## Installation

```bash
    composer require exfriend/laravel-recipe
```

config/app.php
```php
    ...
    
    Exfriend\Recipe\RecipeServiceProvider::class,
    
    ...
```
then call:
```bash
    php artisan recipe:install
```

## Usage
Well, Recipe comes with a couple of built-in recipes available in your `recipes` folder.

Let's generate a new model using the existing `model` recipe:

```bash
    php artisan recipe:make model
```

![Usage example](http://i.imgur.com/N3qYyf3.jpg)

### Using Recipe API inside Laravel
If your application generates some stuff, you can leverage Recipe as a generator core.
```php
 
    $r = recipe( 'model' )->with( [
        'namespace' => '\\App\\Models',
        'class' => 'Post',
        'table' => 'posts',
        'dates' => [ 'created_at', 'updated_at', 'deleted_at' ],
        'relations' => [
            [
                'name' => 'comments',
                'type' => 'hasMany',
                'model' => '\App\Models\Comment',
            ],
            [
                'name' => 'user',
                'type' => 'belongsTo',
                'model' => '\App\Models\User',
            ],
        ],
    ] )->build();
 
    file_put_contents( base_path( 'app/Models/Post.php' ), $r );
 
 
    $r = recipe( 'model' )->with( [
        'namespace' => '\\App\\Models',
        'class' => 'Comment',
        'table' => 'comments',
        'dates' => [ 'created_at', 'updated_at', 'deleted_at' ],
        'relations' => [
            [
                'name' => 'post',
                'type' => 'belongsTo',
                'model' => '\App\Models\Post',
            ],
            [
                'name' => 'author',
                'type' => 'belongsTo',
                'model' => '\App\Models\User',
            ],
        ],
    ] )->build();
 
    file_put_contents( base_path( 'app/Models/Comment.php' ), $r );
 
  
```

## Tutorial
Coming soon

## API
Coming soon

## Contributing
Help us build an amazing tool!

Pull requests and new maintainers are welcome.

Bug and feature requests are welcome in the Issues section.


