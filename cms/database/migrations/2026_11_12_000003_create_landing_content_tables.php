<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stats', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('value');
            $table->string('suffix')->nullable();
            $table->string('label');
            $table->unsignedInteger('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('quick_links', function (Blueprint $table) {
            $table->id();
            $table->string('placement')->index();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('icon')->nullable();
            $table->string('url')->default('#');
            $table->unsignedInteger('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('text');
            $table->string('url')->nullable();
            $table->unsignedInteger('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('service_centers', function (Blueprint $table) {
            $table->id();
            $table->string('badge');
            $table->string('title');
            $table->string('icon')->nullable();
            $table->json('features')->nullable();
            $table->string('link_label')->default('Selengkapnya');
            $table->string('link_url')->default('#');
            $table->unsignedInteger('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('pillars', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('icon')->nullable();
            $table->string('gradient_from')->default('bone-600');
            $table->string('gradient_to')->default('bone-800');
            $table->unsignedInteger('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('service_steps', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->unsignedInteger('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('publications', function (Blueprint $table) {
            $table->id();
            $table->string('badge');
            $table->string('title');
            $table->text('description');
            $table->string('icon')->nullable();
            $table->string('meta_icon')->nullable();
            $table->string('meta_label')->nullable();
            $table->string('meta_value')->nullable();
            $table->string('url')->nullable();
            $table->unsignedInteger('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('logo')->nullable();
            $table->string('url')->nullable();
            $table->unsignedInteger('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('social_links', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->string('icon');
            $table->string('url')->default('#');
            $table->unsignedInteger('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('search_entries', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('url');
            $table->string('category');
            $table->unsignedInteger('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('office_hours', function (Blueprint $table) {
            $table->id();
            $table->string('days');
            $table->string('hours');
            $table->boolean('is_closed')->default(false);
            $table->unsignedInteger('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        foreach (['office_hours', 'search_entries', 'social_links', 'partners', 'publications', 'service_steps', 'pillars', 'service_centers', 'announcements', 'quick_links', 'stats'] as $table) {
            Schema::dropIfExists($table);
        }
    }
};
