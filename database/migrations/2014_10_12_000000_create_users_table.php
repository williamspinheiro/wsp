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
        if (Schema::hasTable('users') == false) {
            Schema::create('users', function (Blueprint $table) {
                $table->increments('id')->unsigned();
                $table->unsignedInteger('profile_id');
                $table->string('name');
                $table->string('alias');
                $table->json('filters')->nullable();
                $table->string('email')->unique();
                $table->string('photo')->nullable();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->rememberToken();
                $table->boolean('active')->default(true);
                $table->boolean('password_temporary')->default(false);
                $table->timestamps();
                $table->softDeletes();
            });

            Schema::table('users', function (Blueprint $table) {
                $table->foreign('profile_id')->references('id')->on('profiles');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
