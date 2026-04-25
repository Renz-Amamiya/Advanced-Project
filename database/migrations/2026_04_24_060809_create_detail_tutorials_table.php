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
    Schema::create('detail_tutorials', function (Blueprint $table) {
        $table->id();
        $table->foreignId('master_tutorial_id')->constrained('master_tutorials')->onDelete('cascade');
        $table->text('text')->nullable();
        $table->string('gambar')->nullable();
        $table->text('code')->nullable(); // Untuk syntax highlighter
        $table->string('url')->nullable();
        $table->integer('order');
        $table->enum('status', ['show', 'hide'])->default('hide');
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_tutorials');
    }
};
