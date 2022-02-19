<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPurchaseOrderCommentsRolesToUserRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_roles', function (Blueprint $table) {
            $table->boolean('purchase_order_comments_show')->default(0);
            $table->boolean('purchase_order_comments_add')->default(0);
            $table->boolean('purchase_order_comments_edit')->default(0);
            $table->boolean('purchase_order_comments_delete')->default(0);
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
                'purchase_order_comments_show',
                'purchase_order_comments_add',
                'purchase_order_comments_edit',
                'purchase_order_comments_delete',
            ]);
        });
    }
}
