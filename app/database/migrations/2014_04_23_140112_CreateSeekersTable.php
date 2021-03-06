<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeekersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('seekers', function(Blueprint $table)
		{
                    $table->increments("id");
                    $table->string("intro","100");
                    $table->string("text","1000");
                    $table->string("cv");
                    $table->string("phone","20")->nullable()->default(NULL);
                    $table->integer('user_id')->unsigned()->unique();
                        $table->foreign('user_id')->references('id')->on('users'); //one user - one job seeking
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
            Schema::dropIfExists('seekers');
	}

}
