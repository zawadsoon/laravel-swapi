<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSwapiCacheTable extends Migration
{
    public function up()
    {
        Schema::create('swapi_cache', function (Blueprint $table) {
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamp('cached_at')->useCurrent();
            $table->primary('key');
        });
    }

    public function down()
    {
        Schema::dropIfExists('swapi_cache');
    }
}
