<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Corrige la tabla customers de la sesión 11 sin editar su migración original:
// - age estaba como date: pasa a número entero (edad en años, 0 a 120)
// - name pasa a 150 caracteres y dni a 8 (DNI peruano), como valida CustomerController
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Primero se quita la columna age (date) ...
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('age');
        });

        // ... y luego se agrega como entero, en su misma posición
        Schema::table('customers', function (Blueprint $table) {
            $table->string('name', 150)->change();
            $table->string('dni', 8)->change();
            $table->unsignedTinyInteger('age')->nullable()->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('age');
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->string('name', 50)->change();
            $table->string('dni')->change();
            $table->date('age')->nullable()->after('phone');
        });
    }
};
