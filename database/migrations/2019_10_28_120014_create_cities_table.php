<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('cities') == false){
            Schema::create('cities', function (Blueprint $table) {
                $table->increments('id')->unsigned();
                $table->string('name');
                $table->unsignedInteger('region_id')->nullable();
                $table->string('alias')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });

            Schema::table('cities', function (Blueprint $table) {
                $table->foreign('region_id')->references('id')->on('regions')->onUpdate('CASCADE')->onDelete('CASCADE');
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
        Schema::dropIfExists('cities');
    }
}
