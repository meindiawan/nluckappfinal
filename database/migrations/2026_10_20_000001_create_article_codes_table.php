<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('article_codes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->cascadeOnDelete();
            $table->string('code', 24)->unique();
            $table->unsignedInteger('batch')->default(1);
            // Terisi saat form berhasil dikirim & pelanggan diarahkan ke grup WhatsApp => QR hangus.
            $table->timestamp('used_at')->nullable();
            $table->foreignId('lead_id')->nullable()->constrained('article_leads')->nullOnDelete();
            // Dinonaktifkan manual oleh admin (mis. QR lama saat "rebuild").
            $table->timestamp('revoked_at')->nullable();
            $table->timestamps();

            $table->index(['article_id', 'used_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('article_codes');
    }
};
