<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tiket', function (Blueprint $table) {
            $table->foreignId('sla_config_override_id')
                  ->nullable()
                  ->after('sla_config_id')
                  ->constrained('sla_config')
                  ->nullOnDelete()
                  ->comment('SLA config final setelah diverifikasi CSIRT saat Triase. NULL = belum dioverride.');

            $table->text('catatan_triase')
                  ->nullable()
                  ->after('sla_config_override_id')
                  ->comment('Alasan CSIRT saat melakukan override urgensi');
        });
    }

    public function down(): void
    {
        Schema::table('tiket', function (Blueprint $table) {
            $table->dropForeign(['sla_config_override_id']);
            $table->dropColumn(['sla_config_override_id', 'catatan_triase']);
        });
    }
};
