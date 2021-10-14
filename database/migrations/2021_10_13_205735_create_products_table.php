<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 10, 4);
            $table->text('description')->nullable();
            
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')
                ->on('categories');

            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('products')->insert([
            [
                'id' => 1, 
                'name' => 'Notebook DELL', 
                'price' => 1999.9999, 
                'category_id' => 1, 
                'created_at' => '2021-10-13 19:19:00'
            ],
            [
                'id' => 2, 
                'name' => 'Notebook HP', 
                'price' => 3999.9999, 
                'category' => 1,
                'created_at' => '2021-10-13 19:19:00'
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
        Schema::dropIfExists('products');
    }
}
