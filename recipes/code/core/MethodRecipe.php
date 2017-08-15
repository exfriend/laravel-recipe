<?php

use Exfriend\Recipe\MakeRecipe;
use Exfriend\Recipe\Recipe;

class MethodRecipe extends Recipe
{
    protected $template = 'stubs.core.method';
    public $props = [
        'visibility' => [
            'default' => 'public',
        ],
        'name' => [
            'default' => '',
        ],
        'args' => [
            'default' => [],
            'type' => 'array',
        ],
        'content' => [
            'default' => '',
        ],
    ];
    public $saveTo = [ 'stdout' ];
    public $description = 'Create a new method';

    public function prepare()
    {
//        dd( $this->data );
    }

}