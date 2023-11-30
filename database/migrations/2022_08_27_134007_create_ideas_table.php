<?php

use App\Models\Idea;
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
        Schema::create('ideas', function (Blueprint $table) {
            $table->id();
            $table->string('idea_file');
            $table->enum('idea_file_type', Idea::FILE_TYPE);
            $table->string('title');
            $table->longText('description');
            $table->longText('link')->nullable();
            $table->string('category');
            $table->enum('privacy_settings', Idea::PRIVACY_SETTINGS)->default('PUBLIC');
            $table->enum('entity_type', Idea::IDEA_TYPE);
            $table->enum('idea_first_type', Idea::TYPE1);
            $table->enum('idea_second_type', Idea::TYPE2);
            $table->enum('investment_strategy', Idea::INVESTMENT_STRATEGY)->nullable();
            $table->string('time_frame')->nullable();
            $table->foreignId('coin_id')->constrained('coins')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->enum('status', Idea::STATUS)->default('PENDING');
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
        Schema::dropIfExists('ideas');
    }
};
