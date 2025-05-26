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
        Schema::create('collaborators', function (Blueprint $table) {
            $table->id();
            $table->string('id_empleado')->unique();
            $table->string('app');
            $table->string('apm')->nullable();
            $table->string('nombre');
            $table->boolean('activo')->default(true);
            $table->string('pass')->nullable();
            $table->integer('tc')->default(1)->nullable();
            $table->string('mail')->nullable();
            $table->integer('perm_fsm')->default(0)->nullable();
            $table->integer('tipoPuesto')->default(3)->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collaborators');
    }
};
