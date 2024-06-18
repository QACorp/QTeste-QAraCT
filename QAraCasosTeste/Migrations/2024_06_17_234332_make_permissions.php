<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Permission::create(['name' => 'QARA_CASOS_TESTE_CONFIGURACAO']);


        $roleAdministrador = Role::findByName('ADMINISTRADOR');
        $roleAdministrador->syncPermissions(Permission::all());

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $roleAdministrador = Role::findByName('ADMINISTRADOR');
        $roleAdministrador->revokePermissionTo('QARA_CASOS_TESTE_CONFIGURACAO');

    }
};
