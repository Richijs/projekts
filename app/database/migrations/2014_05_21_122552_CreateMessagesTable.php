<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('messages', function(Blueprint $table)
		{
			$table->increments("id");
                        $table->string("subject","100");
                        $table->string("message","1000");
                        $table->integer('sender_id')->unsigned();
                            $table->foreign('sender_id')->references('id')->on('users');
                        $table->integer('receiver_id')->unsigned();
                            $table->foreign('receiver_id')->references('id')->on('users');
                        $table->dateTime("created_at")->default(DB::raw('CURRENT_TIMESTAMP'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
            Schema::dropIfExists('messages');
	}

}
