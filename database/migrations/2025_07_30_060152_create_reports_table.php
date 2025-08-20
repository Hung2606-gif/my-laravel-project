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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('report_name');
            $table->timestamps();
             $table->date('report_date')->nullable();
             $table->string('content');
             $table->decimal('working_hours', 4, 2)->nullable();
             $table->unsignedBigInteger('user_id')->nullable(); 
             $table->string('job');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
