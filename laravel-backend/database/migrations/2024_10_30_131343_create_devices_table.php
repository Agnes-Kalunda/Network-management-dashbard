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
    Schema::create('devices', function (Blueprint $table) {
        $table->id();
        $table->string('hostname');
        $table->string('ip_address')->unique();
        $table->enum('type', ['router', 'switch', 'server', 'firewall', 'other']);
        $table->string('model')->nullable();
        $table->string('vendor')->nullable();
        $table->string('location')->nullable();
        $table->string('snmp_community');
        $table->integer('snmp_version')->default(2);
        $table->enum('status', ['up', 'down', 'warning'])->default('up');
        $table->timestamp('last_seen')->nullable();
        $table->timestamps();
    });
}

    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
