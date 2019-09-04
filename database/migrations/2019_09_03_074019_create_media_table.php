<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        $results = DB::select(DB::raw("select version()"));
        $mysql_version = $results[0]->{'version()'};
        Schema::create('media', function (Blueprint $table) use ($mysql_version) {
            $table->bigIncrements('id');
            $table->morphs('model');
            $table->string('collection_name');
            $table->string('name');
            $table->string('file_name');
            $table->string('mime_type')->nullable();
            $table->string('disk');
            $table->unsignedInteger('size');
            if ($mysql_version <= '5.6') {
                $table->longText('manipulations');
                $table->longText('custom_properties');
                $table->longText('responsive_images');
            } else {
                $table->json('manipulations');
                $table->json('custom_properties');
                $table->json('responsive_images');
            }
            $table->unsignedInteger('order_column')->nullable();
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('media');
    }
}
