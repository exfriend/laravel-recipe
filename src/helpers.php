<?php

function recipe( $recipeClassName = null )
{
    return ( new \Exfriend\Recipe\RecipeFactory() )->load( $recipeClassName );
}
