<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Optional customer rating shown on the product detail page.
            // Left null on purpose until an admin actually sets it — the
            // storefront hides the stars entirely instead of showing a
            // made-up number.
            $table->decimal('rating', 2, 1)->nullable()->after('description');
            $table->unsignedInteger('review_count')->nullable()->after('rating');

            // Extra photos shown as thumbnails next to the main image.
            // JSON array of storage paths, same convention as `image`.
            $table->json('gallery')->nullable()->after('image');

            // Color options, e.g. [{"name":"Coklat","hex":"#5c3a2e"}, ...]
            $table->json('colors')->nullable()->after('gallery');

            // Short bullet points ("Bahan premium voal", dst). Falls back
            // to a generic set in the model when left empty.
            $table->json('highlights')->nullable()->after('colors');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['rating', 'review_count', 'gallery', 'colors', 'highlights']);
        });
    }
};
