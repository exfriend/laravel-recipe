{{ '<?' }}php

namespace {{ $namespace }};

use Illuminate\Http\Request;

class AutomationController extends {{ $extends }}
{
    @foreach($functions as $function)
        {!! $function !!}
    @endforeach
}
