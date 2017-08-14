{!! '<?' !!}php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class {{ $class }} extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( '{{ $table }}', function ( Blueprint $table ) {

            @foreach($fields as $field)
                {!! $field !!}
            @endforeach

            {!! $extra !!}

        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop( '{{ $table }}' );
    }
}
