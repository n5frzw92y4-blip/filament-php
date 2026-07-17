<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug');
            $table->integer('category_id');
            $table->string('color');
            $table->string('image');
            $table->string('body');
            $table->boolean('published')->default(false);
            $table->date('published_at');
            $table->timestamps();
        });

        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('post_tags', function (Blueprint $table) {
            $table->foreignId("post_id")->constrained()->cascadeOnDelete();
            $table->foreignId("tag_id")->constrained()->cascadeOnDelete();
            $table->primary(["post_id", "tag_id"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('posts');

        Schema::enableForeignKeyConstraints();    }
};
