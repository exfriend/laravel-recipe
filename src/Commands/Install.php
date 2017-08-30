<?php


namespace Exfriend\Recipe;


use Illuminate\Console\Command as LaravelCommand;

class Install extends LaravelCommand
{

    protected $signature = 'recipe:install';


    public function handle()
    {
//        $this->line( 'Modifying composer.json' );
//        $composerJson = json_decode( file_get_contents( base_path( 'composer.json' ) ) );
//        if ( !in_array( 'recipes/code', $composerJson->autoload->classmap ) )
//        {
//            $composerJson->autoload->classmap [] = 'recipes/code';
//            file_put_contents( base_path( 'composer.json' ), json_encode( $composerJson ) );
//        }
//
//        if ( file_exists( base_path( 'recipes' ) ) )
//        {
//            $this->line( 'Base recipes already installed' );
//            return;
//        }
//
//        $this->line( 'Creating recipes/ folder' );
//        \File::copyDirectory( base_path( 'vendor/exfriend/laravel-recipe/recipes' ), base_path( 'recipes' ) );
//
//        // Need to dump autoload
//        \Artisan::call( 'optimize' );
//
//        $this->line( 'Success! Run <comment>php artisan recipe:list</comment> to get started.' );
    }

}