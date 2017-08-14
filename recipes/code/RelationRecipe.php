<?php

use Exfriend\Recipe\Recipe;

class RelationRecipe extends Recipe
{
    protected $template = 'stubs.relation';

    public $props = [
        'name' => [
            'default' => null,
            'rules' => 'required|alpha',
        ],
        'type' => [
            'default' => null,
            'rules' => 'required|alpha|in:belongsToMany,hasMany,hasManyThrough,belongsTo,hasOne,morphMany,morphTo,morphedByMany',
        ],
        'model' => [
            'default' => null,
            'rules' => [ 'required', 'string' ],
        ],

    ];

    public function prepare()
    {
        $this->data[ 'extra' ] = '';

        if ( $this->data[ 'type' ] == 'hasManyThrough' )
        {
            $this->data[ 'extra' ] = ', ' . $this->data[ 'through' ] . '::class';
        }
    }

}