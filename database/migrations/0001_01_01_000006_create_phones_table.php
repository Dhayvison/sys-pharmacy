<?php

use App\Models\Phone;
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
        Schema::create('phones', function (Blueprint $table) {
            $table->id();
            $table->morphs('phoneable');
            $table->string('country_code', 5);
            $table->string('area_code', 5);
            $table->string('number', 20);
            $table->enum('type', [
                Phone::TYPE_HOME,
                Phone::TYPE_WORK,
                Phone::TYPE_MOBILE,
                Phone::TYPE_WHATSAPP,
            ]);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phones');
    }
};
