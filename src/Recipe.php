<?php

namespace Exfriend\Recipe;

use Exfriend\Recipe\Collections\DataCollection;
use Exfriend\Recipe\Collections\PropsCollection;

class Recipe
{
    protected $data = [];
    protected $props = [];
    protected $view_name;

    public function getViewName()
    {
        return $this->view_name;
    }

    public function __construct()
    {
        $this->loadProps();
        $this->data = new DataCollection();
    }

    public function with( $data )
    {
        $this->data = $this->data->merge( $data );
        return $this;
    }

    public function usingView( $view_name )
    {
        $this->view_name = $view_name;
        return $this;
    }

    public function withSchema( $jsonFileName, $assoc = true )
    {
        return $this->with( json_decode( file_get_contents( $jsonFileName ), $assoc ) );
    }

    public function __toString()
    {
        return $this->build();
    }

    public function build( $saveTo = null )
    {
        $this->buildData();
        $compiled = (string)view( $this->getViewName(), $this->data );
        if ( $saveTo )
        {
            file_put_contents( $saveTo, $compiled );
        }
        return $compiled;
    }

    public function buildData()
    {
        $this->validateParams();

        if ( method_exists( $this, 'prepare' ) )
        {
            $this->prepare();
        }

        return $this->data->toArray();
    }

    protected function validateParams()
    {
        $rules = [];

        foreach ( $this->props as $name => $parameter )
        {
            if ( isset( $parameter[ 'rules' ] ) )
            {
                $rules[ $name ] = $parameter[ 'rules' ];
            }

            if ( isset( $parameter[ 'default' ] ) && !is_null( $parameter[ 'default' ] ) && empty( $this->data[ $name ] ) )
            {
                $this->data[ $name ] = $parameter[ 'default' ];
            }
        }

        $v = \Validator::make( $this->data->toArray(), $rules );

        if ( $v->fails() )
        {
            throw new \Exception( collect( $v->errors()->all() )->implode( PHP_EOL ) );
        }

    }

    protected function loadProps()
    {
        $props = $this->props;
        $this->props = [];

        foreach ( $props as $k => $v )
        {
            $this->props[ $k ] = new Prop( $v );
        }

        $this->props = new PropsCollection( $this->props );
    }

}