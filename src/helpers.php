<?php

function recipe( $recipeClassName )
{
    return ( new \Exfriend\Recipe\RecipeFactory() )->load( $recipeClassName );
}
