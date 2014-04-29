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
            $table->string("username")->unique();
            $table->string("password");
            $table->string("firstname");
            $table->string("lastname");
            $table->string("picture")->nullable()->default(null);
            $table->string("about","500")->nullable()->default(null);
            $table->string("email")->unique();
            $table->string("prefLang","2")->nullable()->default(null);
            $table->tinyInteger("userGroup");
            $table->tinyInteger("active")->nullable()->default(null);
            $table->string("code")->nullable()->default(null);
            $table->string("remember_token")->nullable()->default(null);
            $table->dateTime("created_at");
            $table->dateTime("updated_at");
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
