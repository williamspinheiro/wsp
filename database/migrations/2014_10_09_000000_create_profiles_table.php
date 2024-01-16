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
        if (Schema::hasTable('profiles') == false) {
            Schema::create('profiles', function (Blueprint $table) {
                $table->increments('id')->unsigned();
                $table->string('name')->unique();
                $table->string('alias');
                $table->longText('description')->nullable();
                $table->json('filters')->nullable();
                $table->boolean('active')->default(true);
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
