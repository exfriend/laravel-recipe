<?php

namespace Exfriend\Recipe;

use Illuminate\Support\ServiceProvider;

class RecipeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ( $this->app->runningInConsole() )
        {
            $this->commands( [
                MakeRecipe::class,
                ListRecipes::class,
                Install::class,
            ] );
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
