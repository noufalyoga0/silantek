<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tiket', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_tiket')->unique()->comment('Format: TIK-YYYY-XXX');

            // Relasi OPD dan pelapor
            $table->foreignId('opd_id')->constrained('opd')->cascadeOnDelete();
            $table->foreignId('pelapor_id')->constrained('users')->cascadeOnDelete();

            // Snapshot identitas pelapor (sesuai arahan pembimbing)
            $table->string('nama_pelapor')->comment('Snapshot nama pelapor saat laporan dibuat');
            $table->string('nip_pelapor')->comment('Snapshot NIP pelapor saat laporan dibuat');
            $table->string('jabatan_pelapor')->nullable()->comment('Snapshot jabatan pelapor');
            $table->string('no_hp_pelapor')->nullable()->comment('Snapshot no HP pelapor');

            // Detail insiden
            $table->date('tanggal_kejadian')->comment('Waktu insiden terjadi, bisa berbeda dengan created_at');
            $table->foreignId('jenis_insiden')->constrained('kategori_insiden');
            $table->foreignId('sla_config_id')->constrained('sla_config');
            $table->text('deskripsi');

            // Status dan SLA
            $table->enum('status', ['open', 'triase', 'in_progress', 'resolved', 'reopen', 'closed'])->default('open');
            $table->datetime('sla_deadline')->nullable();
            $table->boolean('is_overdue')->default(false);

            // Timestamps penyelesaian
            $table->timestamp('resolved_at')->nullable()->comment('Diisi otomatis saat status resolved');
            $table->timestamp('closed_at')->nullable()->comment('Diisi otomatis saat status closed');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tiket');
    }
};
