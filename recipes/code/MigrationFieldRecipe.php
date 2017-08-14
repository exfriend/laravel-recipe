<?php

use Exfriend\Recipe\Recipe;

class MigrationFieldRecipe extends Recipe
{
    protected $template = 'stubs.migration_field';

    public function prepare()
    {

    }

    public function interact( \Exfriend\Recipe\MakeRecipe $command )
    {
        $command->line( 'This recipe does not support interaction.' );
    }
}