<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBackupsRolesToUserRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_roles', function (Blueprint $table) {
            $table->boolean('backups_show')->default(0);
            $table->boolean('backups_add')->default(0);
            $table->boolean('backups_download')->default(0);
            $table->boolean('backups_delete')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_roles', function (Blueprint $table) {
            $table->dropColumn([
                'backups_show',
                'backups_add',
                'backups_download',
                'backups_delete',
            ]);
        });
    }
}
