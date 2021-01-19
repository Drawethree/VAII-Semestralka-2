<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FillForumSectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('forums')->insert([
            'title' => 'Cars',
            'description'=> 'Everything related to cars',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('forums')->insert([
            'title' => 'Health',
            'description'=> 'Everything related to health',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('forums')->insert([
            'title' => 'Economics',
            'description'=> 'Everything related to economics',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('forums')->insert([
            'title' => 'Games',
            'description'=> 'Everything related to games',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
