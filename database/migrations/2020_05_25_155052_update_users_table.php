<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('city');
            $table->string('phone')->nullable();
            $table->dropColumn('birthdate');
            $table->dropColumn('company_address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('company_address')->nullable();
            $table->date('birthdate')->nullable();
            $table->dropColumn('city');
            $table->dropColumn('phone');
            //
        });
    }
}
