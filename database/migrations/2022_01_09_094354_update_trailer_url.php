<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateTrailerUrl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!env('testing')) {
            Schema::table('articles', function (Blueprint $table) {
                $table->string('trailer_url', 255)->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //DB::statement('ALTER TABLE `articles` MODIFY COLUMN `trailer_url` VARCHAR(100)');
        Schema::table('articles', function (Blueprint $table) {
            $table->string('trailer_url', 100)->change();
        });
    }
}
