<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('whatsapp_settings', function (Blueprint $table) {
            if (! Schema::hasColumn('whatsapp_settings', 'contact_whatsapp')) {
                $table->string('contact_whatsapp')->nullable()->after('group_link');
            }
            if (! Schema::hasColumn('whatsapp_settings', 'contact_email')) {
                $table->string('contact_email')->nullable()->after('contact_whatsapp');
            }
            if (! Schema::hasColumn('whatsapp_settings', 'instagram_url')) {
                $table->string('instagram_url')->nullable()->after('contact_email');
            }
            if (! Schema::hasColumn('whatsapp_settings', 'tiktok_url')) {
                $table->string('tiktok_url')->nullable()->after('instagram_url');
            }
            if (! Schema::hasColumn('whatsapp_settings', 'facebook_url')) {
                $table->string('facebook_url')->nullable()->after('tiktok_url');
            }
        });
    }

    public function down(): void
    {
        Schema::table('whatsapp_settings', function (Blueprint $table) {
            foreach (['contact_whatsapp', 'contact_email', 'instagram_url', 'tiktok_url', 'facebook_url'] as $column) {
                if (Schema::hasColumn('whatsapp_settings', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
