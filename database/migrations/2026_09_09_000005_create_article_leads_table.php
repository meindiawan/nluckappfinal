<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('article_leads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('whatsapp', 30);
            $table->string('email')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('city')->nullable();
            $table->string('instagram')->nullable();
            $table->boolean('consent')->default(false);
            $table->ipAddress('ip_address')->nullable();
            $table->timestamps();

            $table->index(['article_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('article_leads');
    }
};
