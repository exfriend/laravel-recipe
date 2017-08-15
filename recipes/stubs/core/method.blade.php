@section('args') @isset($args){!! collect($args)->implode(', ') !!}@endisset @endsection

@isset($visibility){!! $visibility !!}@endisset function {{ $name }}(@yield('args')) {
@isset($content)
    {!! $content !!}
@endisset
}