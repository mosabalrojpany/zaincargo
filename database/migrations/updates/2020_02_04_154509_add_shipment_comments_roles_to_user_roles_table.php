<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShipmentCommentsRolesToUserRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_roles', function (Blueprint $table) {
            $table->boolean('shipment_comments_show')->default(0);
            $table->boolean('shipment_comments_add')->default(0);
            $table->boolean('shipment_comments_edit')->default(0);
            $table->boolean('shipment_comments_delete')->default(0);
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
                'shipment_comments_show',
                'shipment_comments_add',
                'shipment_comments_edit',
                'shipment_comments_delete',
            ]);
        });
    }
}
