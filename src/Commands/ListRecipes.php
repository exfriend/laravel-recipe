<?php


namespace Exfriend\Recipe;


use Illuminate\Console\Command as LaravelCommand;

class ListRecipes extends LaravelCommand
{

    protected $signature = 'recipe:list';


    public function handle()
    {
        $kitchen = collect( require( base_path( 'recipes/config.php' ) ) )->map( function ( $v, $k ) {
            return [ $k, app( $v )->description ];
        } );

        $this->table( [ 'Recipe', 'Description' ], $kitchen );
    }

}