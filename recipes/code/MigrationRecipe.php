<?php

use Exfriend\Recipe\Recipe;

class MigrationRecipe extends Recipe
{
    protected $template = 'stubs.migration';

    public function prepare()
    {
        $this->data[ 'fields' ] = collect( $this->data[ 'fields' ] )->map( function ( $rel ) {
            return recipe( 'migration_field' )->with( [ 'field' => $rel ] )->build();
        } );

    }

    public function interact( \Exfriend\Recipe\MakeRecipe $command )
    {
        $command->line( 'This recipe does not support interaction.' );
    }
}