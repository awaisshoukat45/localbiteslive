<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExtraGroupIdToExtras extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('extras', function (Blueprint $table) {
            $table->unsignedBigInteger('extra_group_id')->after('item_id')->nullable();
            $table->foreign('extra_group_id')->references('id')->on('extra_groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('extras', function (Blueprint $table) {
            $table->dropForeign(['extra_group_id']);
            $table->dropColumn('extra_group_id');
        });
    }
}
