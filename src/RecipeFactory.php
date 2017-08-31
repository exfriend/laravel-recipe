<?php

namespace Exfriend\Recipe;


class RecipeFactory
{
    public function load( $recipeClassName = null )
    {
        return app( $recipeClassName ?? Recipe::class );
    }
}