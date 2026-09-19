<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('whatsapp_settings', function (Blueprint $table) {
            $table->id();
            $table->string('group_name')->default('NLUCK Society');
            $table->text('group_link');
            $table->string('success_title')->default('Terima kasih!');
            $table->text('success_message')->default('Data Anda sudah kami terima. Silakan lanjut ke WhatsApp Group.');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('whatsapp_settings');
    }
};
