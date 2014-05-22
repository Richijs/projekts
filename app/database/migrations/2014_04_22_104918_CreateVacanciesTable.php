<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVacanciesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            Schema::create('vacancies', function(Blueprint $table)
            {
                $table->increments("id");
                $table->string("name","100")->unique();
                $table->string("company","100")->nullable()->default(null);
                $table->string("poster")->nullable()->default(null);
                $table->string("phone","20")->nullable()->default(null);
                $table->string("text","1000");
                $table->integer('creator_id')->unsigned();
                    $table->foreign('creator_id')->references('id')->on('users');
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
            Schema::dropIfExists('vacancies');
	}

}
