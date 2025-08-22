<?php

use App\Models\ModelHistory;
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
        Schema::create('model_history', function (Blueprint $table) {
            $table->id();
            $table->morphs('model');
            $table->enum('action', [
                ModelHistory::ACTION_CREATED,
                ModelHistory::ACTION_UPDATED,
                ModelHistory::ACTION_DELETED,
            ]);
            $table->json('changes')->nullable();
            $table->foreignUuid('user_id')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_history');
    }
};
