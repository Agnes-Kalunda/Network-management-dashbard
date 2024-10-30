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
    Schema::create('device_interfaces', function (Blueprint $table) {
        $table->id();
        $table->foreignId('device_id')->constrained()->onDelete('cascade');
        $table->string('name');
        $table->string('mac_address')->nullable();
        $table->string('ip_address')->nullable();
        $table->boolean('is_enabled')->default(true);
        $table->enum('status', ['up', 'down'])->default('up');
        $table->bigInteger('speed')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_interfaces');
    }
};
