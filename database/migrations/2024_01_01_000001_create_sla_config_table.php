<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sla_config', function (Blueprint $table) {
            $table->id();
            $table->enum('urgensi', ['rendah', 'sedang', 'tinggi', 'kritis'])->unique();
            $table->integer('durasi_jam')->comment('Batas waktu SLA dalam jam');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sla_config');
    }
};
