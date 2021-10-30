<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    private $table = 'clients';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('cpf_cnpj')->unique();
            $table->string('phone')->unique();
            $table->string('zip_code');
            $table->string('district');
            $table->string('city');
            $table->char('uf', 2);
            $table->softDeletes();
            $table->timestamps();
        });

        DB::table($this->table)->insert([
            [
                'id' => 1,
                'name' => 'Cristiano Junior',
                'email' => 'cristiano-junior10@outlook.com',
                'cpf_cnpj' => '96325874125',
                'phone' => '21000000000',
                'zip_code' => '25807010',
                'district' => 'Centro',
                'city' => 'Três Rios',
                'uf' => 'RJ',
                'created_at' => now()
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
