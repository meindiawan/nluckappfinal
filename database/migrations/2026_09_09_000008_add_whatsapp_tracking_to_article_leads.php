<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('article_leads', function (Blueprint $table) {
            if (! Schema::hasColumn('article_leads', 'source_url')) {
                $table->text('source_url')->nullable()->after('consent');
            }
            if (! Schema::hasColumn('article_leads', 'whatsapp_clicked_at')) {
                $table->timestamp('whatsapp_clicked_at')->nullable()->index()->after('updated_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('article_leads', function (Blueprint $table) {
            if (Schema::hasColumn('article_leads', 'whatsapp_clicked_at')) {
                $table->dropColumn('whatsapp_clicked_at');
            }
            if (Schema::hasColumn('article_leads', 'source_url')) {
                $table->dropColumn('source_url');
            }
        });
    }
};
