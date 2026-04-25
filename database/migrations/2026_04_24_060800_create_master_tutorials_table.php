<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('master_tutorials', function (Blueprint $table) {
        $table->id();
        $table->string('judul');
        $table->string('kode_mk'); // didapat dari API
        $table->string('url_presentation')->unique();
        $table->string('url_finished')->unique();
        $table->string('creator_email');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_tutorials');
    }
};
