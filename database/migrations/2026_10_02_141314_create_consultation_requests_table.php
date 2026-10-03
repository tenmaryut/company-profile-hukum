<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultation_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('practice_area_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name', 100);
            $table->string('email', 150);
            $table->string('phone', 30)->nullable();
            $table->text('message');
            $table->string('status', 20)->default('baru')->index();
            $table->text('admin_note')->nullable();
            $table->timestamp('consented_at');
            // Hash token cookie pengirim: akun demo hanya melihat kiriman dari browsernya sendiri.
            $table->string('submitter_token_hash', 64)->nullable()->index();
            $table->boolean('is_sample')->default(false);
            $table->timestamps();
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultation_requests');
    }
};
