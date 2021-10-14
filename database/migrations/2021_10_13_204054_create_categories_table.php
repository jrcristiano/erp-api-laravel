<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        DB::table('categories')->insert([
            [
                'id' => 1, 
                'name' => 'ELETRÔNICOS',
                'created_at' => '2021-01-01 13:28:05'
            ],
            [
                'id' => 2, 
                'name' => 'ELETRODOMÉSTICOS',
                'created_at' => '2021-01-01 13:28:05'
            ],
            [
                'id' => 3, 
                'name' => 'OUTROS',
                'created_at' => '2021-01-01 13:28:05'
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
