# Laravel Recipe
Generator framework for Laravel built on Laravel.

## Installation

On Laravel 5.5:

```bash
    composer require exfriend/laravel-recipe
```

## Basic Usage

In order to generate any entity you basically need two things: a template and the actual data.

Recipe uses Laravel's Blade as a template engine for stubs, so
the basic usage is very similar to how you return views from controllers.

Let's write our first recipe that would generate any class.
 
1. Create a new view inside `resources/views/recipe` folder:

resources/views/recipe/class.blade.php
```blade

{!! '<'.'?php' !!}

@unless(empty( $namespace ))
namespace {{ $namespace }};
@endunless

@unless(empty( $imports ))
@foreach( $imports as $import)
import {{ $import }};
@endforeach
@endunless

class {{ $class }} {{ isset($extends) ? 'extends '. $extends : '' }} {{ !empty($implements) ? 'implements '. collect($implements)->implode(', ') : '' }}
{
@unless(empty($traits))
    use {{ collect($traits)->implode(', ') }};
@endunless

@isset($content)
    {!! $content !!}
@endisset
}

```

Then anywhere in your code you can run:

```blade
 
   $recipe = recipe()->usingView( 'recipes.class' )->with( [
        'namespace' => 'App',
        'class' => 'User',
        'extends' => 'Authenticatable',

        'imports' => [
            'Illuminate\Foundation\Auth\User as Authenticatable',
            'Illuminate\Notifications\Notifiable',
            'Laravel\Passport\HasApiTokens',
        ],

        'traits' => [
            'HasApiTokens',
            'Notifiable',
        ],
//            'implements' => [ 'SomeInterface', 'OtherInterface' ],
    ] );
    
```

Get the compiled code:

```php
    dd( $recipe->build() )
```

Save to file:

```php
    $recipe->build( app_path('User.php') );
```

Now let's create a dedicated class for this recipe to make it easier.

app/Recipes/ClassRecipe.php
```php
<?php
 
namespace App\Recipes;
 
 
class ClassRecipe extends \Exfriend\Recipe\Recipe
{
    
    public $props = [
        'class' => [
            'rules' => 'required',
        ],
        'content' => [ 'default' => '', ],
        'imports' => [ 'default' => [], ],
    ];
 
    protected $view_name = 'recipes.class';
     
}
 
```

Here you can notice that we're hardcoding the template name and defining a new `$props` variable which is somewhat similar to what Vue uses in it's components.

Two important things happen here: 

First, we added some validation telling Recipe that `class` property is mandatory in this recipe. You can set the rules property just like you normally would in your Laravel application - that's the same thing.

Second, we're setting default values for `content` and `import`. Those defaults will be applied if the user does not provide anything as the input.

So, our resulting usage will now look like this:

```php
    $recipe = ( \App\Recipes\ClassRecipe::class )->with( [
        'namespace' => 'App',
        'class' => 'User',
        'extends' => 'Illuminate\Foundation\Auth\User',
    ] )
    ->build( app_path('User.php') );
```

An important note: 

Because of props, the actual data passed to a template will be slightly different from what we passed in. For example, it will have `content` and `imports`.
Sometimes you would like to just get the transformed data withour compiling the whole template (e.g. for nested recipes, see below).
To only get the compiled data, run:

```php

    $recipe = ( \App\Recipes\ClassRecipe::class )->with( [
        ...
    ] )
    ->buildData();
```

Since we are generating a model here and model is something we'd like to generate often, it makes sense to create a dedicated Model recipe based on a general class recipe we already have.
Let's make a simple Model recipe:

app/Recipes/ModelRecipe.php
```php

```


## Advanced Usage

Coming soon.