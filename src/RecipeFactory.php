<?php


namespace Exfriend\Recipe;


class RecipeFactory
{

    public function load( $recipeClassName )
    {
        return app( $recipeClassName );
    }
}