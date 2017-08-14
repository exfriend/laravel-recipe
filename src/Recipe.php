<?php

namespace Exfriend\Recipe;


use Exfriend\Recipe\Collections\ConfigCollection;
use Exfriend\Recipe\Collections\DataCollection;
use Exfriend\Recipe\Collections\PropsCollection;

abstract class Recipe
{
    public $data = [];
    public $props = [];
    protected $config = [];

    public $description = '';

    public $saveTo = [ 'stdout', 'file' ];

    protected $template;
    protected $interactMap = [
        'prop_name' => 'interacrAboutPropName',
    ];

    public function getDefaultFilePath()
    {
        return base_path();
    }

    public function __construct()
    {
        $this->loadProps();
        $this->data = new DataCollection();
        $this->config = new ConfigCollection();
    }

    public function withConfig( array $config )
    {
        $this->config = $this->config->merge( $config );
    }

    public function with( $data )
    {
        $this->data = $this->data->merge( $data );
        return $this;
    }

    public function withSchema( $jsonFileName )
    {
        return $this->with( json_decode( file_get_contents( $jsonFileName ), true ) );
    }

    public function __toString()
    {
        return $this->build();
    }

    public function build()
    {
        $this->validateParams();

        if ( method_exists( $this, 'prepare' ) )
        {
            $this->prepare();
        }

        view()->addNamespace( 'recipes', base_path( 'recipes' ) );
        $compiled = (string)view( 'recipes::' . $this->template, $this->data );

        return $compiled;
    }

    protected function validateParams()
    {
        $rules = [];

        foreach ( $this->props as $name => $parameter )
        {
            if ( is_array( $parameter ) && isset( $parameter[ 'rules' ] ) )
            {
                $rules[ $name ] = $parameter[ 'rules' ];
                if ( !is_null( $parameter[ 'default' ] ) && empty( $this->data[ $name ] ) )
                {
                    $this->data[ $name ] = $parameter[ 'default' ];
                }
            }
        }
        $v = \Validator::make( $this->data->toArray(), $rules );


        if ( $v->fails() )
        {
            throw new \Exception( collect( $v->errors()->all() )->implode( PHP_EOL ) );
        }

    }

    public function interact( MakeRecipe $command )
    {
        foreach ( $this->props as $name => $prop )
        {
            // Search interactMap. If mapping exists, call it.
            if ( collect( $this->interactMap )->has( $name ) )
            {
                call_user_func( [ $this, $this->interactMap[ $name ] ], $command, $prop );
                continue;
            }

            // Search "magic" method
            elseif ( method_exists( $this, 'interactAbout' . studly_case( $name ) ) )
            {
                call_user_func( [ $this, 'interactAbout' . studly_case( $name ) ], $command, $prop );
                continue;
            }
            else
            {
                // No interaction. Try to guess the fallback?
                $this->defaultInteraction( $command, $prop, $name );
                continue;
            }
        }
    }

    private function defaultInteraction( MakeRecipe $command, $prop, $name )
    {
        if ( !isset( $prop[ 'type' ] ) || $prop[ 'type' ] == 'string' )
        {
            $question = 'Set ' . $name;
            if ( isset( $prop[ 'example' ] ) )
            {
                $question .= ' (e.g. ' . $prop[ 'example' ] . ')';
            }

            $value = $command->ask( $question, $prop[ 'default' ] );
            $this->data->put( $name, $value );
        }
    }

    protected function loadProps()
    {
        $props = $this->props;
        $this->props = [];

        foreach ( $props as $k => $v )
        {
            if ( !is_array( $v ) )
            {
                $this->props[ $v ] = [ 'default' => '' ];
            }
            else
            {
                $this->props[ $k ] = $v;
            }

        }

        $this->props = new PropsCollection( $this->props );
    }

}