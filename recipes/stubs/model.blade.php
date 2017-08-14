{!! '<?' !!}php namespace {!! $namespace !!};

class {!! $class !!} extends {!! $extends !!} @isset($implements) {!! collect($implements)->implode(',') !!} @endisset
{
    @if( isset($traits) && count($traits) )
        use {!! collect($traits)->implode(',') !!};
    @endisset

    public $table = '{!! $table !!}';
    @isset($dates)
    public $dates = ['{!! collect($dates)->implode('\',\'') !!}'];
    @endisset

    @if( isset( $guarded ) && count($guarded) )
        protected $guarded = [ @foreach($guarded as $g) '{!! $g !!}', @endforeach ];
    @else
        protected $guarded = [];
    @endif

    @if( isset( $hidden ) && count($hidden) )
        protected $hidden = [ @foreach($hidden as $g) '{!! $g !!}', @endforeach ];
    @else
        protected $hidden = [];
    @endif

    @isset($casts)
    protected $casts = [
    @foreach($casts as $castName => $castValue)
        '{!! $castName !!}' => '{!! $castValue !!}',
    @endforeach
    ];
    @endisset

    /*
    * Relations
    */

    {!! $relations !!}

    /*
    * Other Stuff
    */

    @isset($other)
    {!! $other !!}
    @endisset
}
