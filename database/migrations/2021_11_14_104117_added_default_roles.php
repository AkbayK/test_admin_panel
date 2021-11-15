<?php

use App\Models\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddedDefaultRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Role::create([
            'name' => 'Админ',
            'slug' => 'admin',
        ]);
        Role::create([
            'name' => 'Менеджер',
            'slug' => 'manager',
        ]);
        Role::create([
            'name' => 'Сотрудник',
            'slug' => 'employee',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $roles = Role::whereIn('slug', ['admin', 'manager', 'employee'])->get();
        foreach ($roles as $role) {
            $role->delete();
        }
    }
}
