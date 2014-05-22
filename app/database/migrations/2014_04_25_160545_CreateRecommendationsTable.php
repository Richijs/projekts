<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecommendationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('recommendations', function(Blueprint $table)
		{
                    $table->increments("id");
                    $table->integer('user_id')->unsigned();
                        $table->foreign('user_id')->references('id')->on('users'); //one user - one job seeking
                    $table->integer('employer_id')->unsigned();
                        $table->foreign('employer_id')->references('id')->on('users'); //one user - one job seeking
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
            Schema::dropIfExists('recommendations');
	}

}
