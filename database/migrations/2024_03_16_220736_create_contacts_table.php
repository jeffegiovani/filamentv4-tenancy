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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tenant_id')->unsigned();
            $table->index('tenant_id');
            $table->string('name', 120);
            $table->date('birth_date')->nullable();
            $table->json('emails')->nullable();
            $table->json('phones')->nullable();
            $table->json('identification_documents')->nullable();
            $table->json('addresses')->nullable();
            $table->json('urls')->nullable();
            $table->text('info')->nullable()->default(null);
            $table->boolean('is_company')->default(false);

            $table->string('utm_source_id')->nullable()->default(1);
            $table->tinyText('utm_source_uri_or_detail')->nullable();

            $table->timestamps();
            $table->softDeletes();
            $table->index('deleted_at');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
