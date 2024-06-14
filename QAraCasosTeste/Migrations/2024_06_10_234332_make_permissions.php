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
        Permission::create(['name' => 'QARA_CASOS_TESTE_INSERIR']);


        $roleAdministrador = Role::findByName('ADMINISTRADOR');
        $roleAdministrador->syncPermissions(Permission::all());

        $roleAuditor = Role::findByName('AUDITOR');
        $roleAuditor->givePermissionTo([
                'QARA_CASOS_TESTE_INSERIR'
            ]);
        $roleGestor = Role::findByName('GESTOR');
        $roleGestor->givePermissionTo([
                'QARA_CASOS_TESTE_INSERIR'
            ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $roleAdministrador = Role::findByName('ADMINISTRADOR');
        $roleAdministrador->revokePermissionTo('QARA_CASOS_TESTE_INSERIR');

        $roleGestor = Role::findByName('GESTOR');
        $roleGestor->revokePermissionTo('QARA_CASOS_TESTE_INSERIR');

        $roleGestor = Role::findByName('AUDITOR');
        $roleGestor->revokePermissionTo('QARA_CASOS_TESTE_INSERIR');

    }
};
