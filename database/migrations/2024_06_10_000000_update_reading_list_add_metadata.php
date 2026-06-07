<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reading_list', function (Blueprint $table) {
            $table->string('title')->nullable()->after('comic_id');
            $table->text('description')->nullable()->after('title');
            $table->string('thumbnail_url')->nullable()->after('description');
            $table->integer('page_count')->nullable()->after('thumbnail_url');
            $table->date('published_at')->nullable()->after('page_count');
            $table->boolean('is_favorite')->default(false)->after('status');
            $table->json('characters')->nullable()->after('is_favorite');
            $table->json('creators')->nullable()->after('characters');
            $table->string('marvel_url')->nullable()->after('creators');

            $table->index('is_favorite');
            $table->unique(['user_id', 'comic_id'], 'reading_list_user_comic_unique');
        });
    }

    public function down(): void
    {
        Schema::table('reading_list', function (Blueprint $table) {
            $table->dropUnique('reading_list_user_comic_unique');
            $table->dropIndex(['is_favorite']);
            $table->dropColumn([
                'title', 'description', 'thumbnail_url', 'page_count',
                'published_at', 'is_favorite', 'characters', 'creators', 'marvel_url',
            ]);
        });
    }
};
