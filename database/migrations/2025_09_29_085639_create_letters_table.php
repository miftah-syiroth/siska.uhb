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
        Schema::create('letters', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users');
            $table->foreignUuid('letter_type_id')->constrained('letter_types');
            $table->string('number')->index();
            $table->string('ticket_number')->index();
            $table->string('subject');
            // penerima
            $table->string('recipient');
            // alamat penerima
            $table->text('recipient_address');
            // tanggal surat
            $table->date('letter_date')->nullable();
            // expired surat
            $table->date('expired_date')->nullable();
            // status surat
            $table->string('status')->index();;
            // catatan surat
            $table->text('note')->nullable();
            // file surat
            $table->string('file_path')->nullable();
            // content json
            $table->json('json_content')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letters');
    }
};
