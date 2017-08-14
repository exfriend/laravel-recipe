@isset($field['nullable'])
        @push('extra_params')->nullable()@endpush
@endisset
@isset($field['unique'])
    @push('extra_params')->unique()@endpush
@endisset
@isset($field['index'])
        @push('extra_params')->index()@endpush
@endisset
@isset($field['default'])
        @push('extra_params')->default({!! $field['default'] !!})@endpush
@endisset
$table->{{$field['type']}}(@isset($field['name']) '{{ $field['name'] }}'{{ isset($field['param'] ) ? ' , '.$field['param'] : '' }} @endisset )@stack('extra_params');