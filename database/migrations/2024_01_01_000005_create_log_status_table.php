<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('log_status', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tiket_id')->constrained('tiket')->cascadeOnDelete();
            $table->string('status_lama')->nullable()->comment('Nullable karena tiket baru belum punya status sebelumnya');
            $table->string('status_baru');
            $table->text('catatan')->nullable();
            $table->foreignId('diubah_oleh')->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_status');
    }
};
