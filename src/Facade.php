<?php

namespace Exfriend\Recipe;


class Facade extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return RecipeFactory::class;
    }
}