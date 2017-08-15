<?php

use Exfriend\Recipe\MakeRecipe;
use Exfriend\Recipe\Recipe;

class ModelRecipe extends Recipe
{
    protected $template = 'stubs.model';
    public $props = [

        'namespace' => [
            'default' => '\\App\\Models',
            'rules' => 'required',
            'example' => '\\App\\Models',
            'question' => 'Namespace?',
        ],
        'class' => [
            'default' => '',
            'rules' => 'required',
            'example' => 'User',
        ],
        'extends' => [
            'default' => 'Illuminate\\Database\\Eloquent\\Model',
            'rules' => 'required',
            'example' => 'Illuminate\\Database\\Eloquent\\Model',
        ],
        'implements' => [
            'type' => 'array',
            'default' => [],
            'rules' => 'present|array',
            'items' => [
                'default' => '',
                'rules' => 'required',
                'example' => 'SerializesModels',
            ],
        ],
        'traits' => [
            'type' => 'array',
            'default' => [],
            'rules' => 'present|array',
            'items' => [
                'default' => '',
                'rules' => 'required',
                'example' => 'HasRolesAndAbilities',
            ],
        ],
        'table' => [
            'default' => '',
            'rules' => 'required',
            'example' => 'users',
        ],

        'dates' => [
            'type' => 'array',
            'default' => [ 'created_at', 'updated_at' ],
            'rules' => 'present|array',
            'items' => [
                'default' => '',
                'rules' => 'required',
                'example' => 'deleted_at',
            ],
        ],

        'guarded' => [
            'type' => 'array',
            'default' => [],
            'rules' => 'present|array',
            'items' => [
                'default' => '',
                'rules' => 'required',
                'example' => 'password',
            ],
        ],

        'hidden' => [
            'type' => 'array',
            'default' => [],
            'rules' => 'present|array',
            'items' => [
                'default' => '',
                'rules' => 'required',
                'example' => 'api_token',
            ],
        ],
        'casts' => [
            'type' => 'array',
            'default' => [],
        ],

        'relations' => [
            'type' => 'array',
            'default' => [],
            'rules' => 'present|array',
            'items' => [
                'default' => '',
                'rules' => 'required',
            ],
        ],

    ];

    public $description = 'Create a new model';

    public function getDefaultFilePath()
    {
        return 'app' . DIRECTORY_SEPARATOR . 'Models' . DIRECTORY_SEPARATOR . $this->data->get( 'class' ) . '.php';
    }

    public function interactAboutTable( MakeRecipe $command, $prop )
    {
        $this->data->put( 'table', $command->ask( 'Table?', str_plural( snake_case( $this->data->get( 'class', '' ) ) ) ) );
    }

    public function interactAboutRelations( MakeRecipe $command, $prop )
    {
        $this->data[ 'relations' ] = collect();

        if ( !$command->confirm( 'Generate relationships?', true ) )
        {
            return;
        }

        $thisIsFirstIteration = true;
        while ( $thisIsFirstIteration || $command->confirm( 'Create another relation?' ) )
        {
            $thisIsFirstIteration = false;

            $possibleRelations = [ 'belongsToMany', 'hasMany', 'hasManyThrough', 'belongsTo', 'hasOne', 'morphMany', 'morphTo', 'morphedByMany' ];

            $type = $command->choice( 'Which type?', $possibleRelations );

            $existingModels = collect( get_declared_classes() )->filter( function ( $c ) {
                return is_subclass_of( $c, \Illuminate\Database\Eloquent\Model::class );
            } )->map( function ( $c ) {
                return '\\' . ltrim( $c, '\\' );
            } )->sort()->values();

            $model = $command->choiceOrEnterManually( 'Which model?', $existingModels, 'Model name?', false );

            $possible_relation_name = (string)( string( $model )->lastSegment( '\\' ) );
            $pluralRelations = [ 'belongsToMany', 'hasMany', 'hasManyThrough', 'morphMany', 'morphTo', 'morphedByMany' ];

            $possible_relation_name = in_array( $type, $pluralRelations ) ? str_plural( $possible_relation_name ) : $possible_relation_name;
            $possible_relation_name = snake_case( $possible_relation_name );

            $name = $command->ask( 'Name of the relationship?', $possible_relation_name );

            $this->data[ 'relations' ][] = [ 'name' => $name, 'type' => $type, 'model' => $model, ];
        }

        return;
    }

    public function prepare()
    {
        $this->data[ 'relations' ] = collect( $this->data->get( 'relations' ) )->map( function ( $rel ) {
            return recipe( 'relation' )->with( $rel )->build();
        } )->implode( PHP_EOL . PHP_EOL );
    }


}