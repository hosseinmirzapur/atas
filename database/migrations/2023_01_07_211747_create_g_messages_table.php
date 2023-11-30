<?php

use App\Models\GMessage;
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
        Schema::create('g_messages', function (Blueprint $table) {
            $table->id();
            $table->text('text')->nullable();
            $table->string('media')->nullable();
            $table->foreignId('group_id')->constrained('groups')->cascadeOnDelete();
            $table->unsignedBigInteger('owner_id');
            $table->enum('owner_type', GMessage::OWNER_TYPES);
            $table->foreignId('g_message_id')->constrained('g_messages')->cascadeOnDelete();
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
        Schema::dropIfExists('g_messages');
    }
};
