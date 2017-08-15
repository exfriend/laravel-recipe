<?php

namespace Exfriend\Recipe;

use Illuminate\Contracts\Support\Arrayable;

class Prop implements Arrayable, \ArrayAccess
{
    protected $item;

    /**
     * Prop constructor.
     * @param $item
     */
    public function __construct( $item )
    {
        $this->item = $item;
    }

    /*
     * Methods
     */

    public function isScalar()
    {
        return !isset( $this->item[ 'type' ] ) || $this->item[ 'type' ] == 'string';
    }


    public function isRequired()
    {
        if ( !$this->item[ 'rules' ] )
        {
            return false;
        }

        if ( is_array( $this->item[ 'rules' ] ) && in_array( 'required', $this->item[ 'rules' ] ) )
        {
            return true;
        }
        if ( preg_match( '~required[^_]~is', $this->item[ 'rules' ] ) )
        {
            return true;
        }

        return false;
    }

    /*
     * Boring stuff
     */


    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->item;
    }

    /**
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists( $offset )
    {
        return isset( $this->item[ $offset ] );
    }

    /**
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet( $offset )
    {
        return $this->item[ $offset ];
    }

    /**
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetSet( $offset, $value )
    {
        $this->item[ $offset ] = $value;
    }

    /**
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset( $offset )
    {
        unset( $this->item[ $offset ] );
    }
}
