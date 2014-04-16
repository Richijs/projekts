<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
    public function up()
        {
        Schema::create("users", function(Blueprint $table)
        {
            //ar laiku jāsamaina korekti
            $table->increments("id");
            $table->string("username")->nullable()->default(null);
            $table->string("password")->nullable()->default(null);
            $table->string("firstname")->nullable()->default(null);
            $table->string("lastname")->nullable()->default(null);
            $table->string("about")->nullable()->default(null);
            $table->string("email")->nullable()->default(null);
            $table->string("prefLang","2")->nullable()->default(null);
            $table->tinyInteger("userGroup")->nullable()->default(null);
            $table->tinyInteger("status")->nullable()->default(null);
            $table->string("code")->nullable()->default(null);
            $table->dateTime("created_at")->nullable()->default(null);
            $table->dateTime("updated_at")->nullable()->default(null);
        });
        
    }

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
            Schema::dropIfExists("users");
	}

}
