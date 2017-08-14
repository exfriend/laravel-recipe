<?php

namespace Exfriend\Recipe;

class RecipeFactory
{
    public static function findRecipe( $name )
    {
        $kitchen = require( base_path( 'recipes/config.php' ) );


        if ( in_array( $name, array_keys( $kitchen ) ) )
        {
            return app( $kitchen[ $name ] );
        }

        throw new \Exception( 'No recipe found' );
    }

}