<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWalletPermissionsToUserRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_roles', function (Blueprint $table) {
            $table->boolean('user_wallet_index')->default(0);
            $table->boolean('user_wallet_show')->default(0);
            $table->boolean('user_wallet_add')->default(0);
            $table->boolean('user_wallet_statement')->default(0);

            $table->boolean('user_wallet_depoprint')->default(0);
            $table->boolean('user_wallet_edit')->default(0);
            $table->boolean('user_wallet_delete')->default(0);
            $table->boolean('user_wallet_editdelet')->default(0);

            $table->boolean('user_wallet_alldepo')->default(0);
            $table->boolean('user_wallet_allwather')->default(0);
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
                'user_wallet_index',
                'user_wallet_show',
                'user_wallet_add',
                'user_wallet_statement',
                'user_wallet_depoprint',
                'user_wallet_edit',
                'user_wallet_delete',
                'user_wallet_editdelet',
                'user_wallet_alldepo',
                'user_wallet_allwather',
            ]);
        });
    }
}
