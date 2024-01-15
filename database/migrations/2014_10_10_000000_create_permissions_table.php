<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('permissions') == false) {
            Schema::create('permissions', function (Blueprint $table) {
                $table->increments('id')->unsigned();
                $table->unsignedInteger('parent_id')->nullable();
                $table->string('name')->unique();
                $table->string('alias');
                $table->text('description')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });

            Schema::table('permissions', function (Blueprint $table) {
                $table->foreign('parent_id')->references('id')->on('permissions')->onUpdate('CASCADE')->onDelete('CASCADE');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
