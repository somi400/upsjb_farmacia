<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('rol_id')->nullable()->after('id')->constrained('roles')->restrictOnDelete();
            $table->string('dni', 15)->nullable()->unique()->after('name');
            $table->string('telefono', 20)->nullable()->after('dni');
            $table->string('colegiatura', 30)->nullable()->after('telefono');
            $table->boolean('status')->default(true)->after('password');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['rol_id']);
            $table->dropColumn(['rol_id', 'dni', 'telefono', 'colegiatura', 'status']);
        });
    }
};
