<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('password');
            $table->float('reputation')->default(0);
            $table->boolean('sms_when_followed')->default(false);
            $table->boolean('email_when_followed')->default(false);
            $table->boolean('sms_when_replied')->default(false);
            $table->boolean('email_when_replied')->default(false);
            $table->boolean('sms_when_commented')->default(false);
            $table->boolean('email_when_commented')->default(false);
            $table->enum('status', User::STATUS)->default('FRESH');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
