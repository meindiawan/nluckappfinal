<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('article_form_settings', function (Blueprint $table) {
            $table->id();
            $table->string('title', 160)->default('Gabung NLUCK Society');
            $table->text('description')->nullable();
            $table->string('cta_text', 100)->default('DAFTAR SEKARANG');
            $table->string('success_title', 160)->default('Data berhasil diterima');
            $table->text('success_message')->nullable();
            $table->string('consent_text', 500)->default('Saya bersedia menerima informasi produk terbaru dari NLUCK Scarves.');
            $table->boolean('show_name')->default(true);
            $table->boolean('show_whatsapp')->default(true);
            $table->boolean('show_email')->default(true);
            $table->boolean('show_birth_date')->default(true);
            $table->boolean('show_city')->default(true);
            $table->boolean('show_instagram')->default(true);
            $table->boolean('require_email')->default(false);
            $table->boolean('require_birth_date')->default(false);
            $table->boolean('require_city')->default(false);
            $table->boolean('require_instagram')->default(false);
            $table->boolean('require_consent')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('article_form_settings'); }
};
