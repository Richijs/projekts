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
                    //ar laiku jāsamaina korekti
                $table->increments("id");
                $table->string("name")->nullable()->default(null);
                $table->string("poster")->nullable()->default(null);
                $table->string("text","500")->nullable()->default(null);
                $table->integer('creator_id')->unsigned();
                    $table->foreign('creator_id')->references('id')->on('users');
                $table->dateTime("created_at")->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
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
