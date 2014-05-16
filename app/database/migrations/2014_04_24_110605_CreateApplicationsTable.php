<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('applications', function(Blueprint $table)
		{
                        //ar laiku jāsamaina korekti
                    $table->increments("id");
                    $table->integer('user_id')->unsigned();
                        $table->foreign('user_id')->references('id')->on('users'); //one user can apply many vacancies
                    $table->integer('vacancie_id')->unsigned();
                        $table->foreign('vacancie_id')->references('id')->on('vacancies'); //many users can apply one vacancie
                    $table->string("letter","1000");
                    $table->tinyInteger("viewed")->nullable()->default(0);
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
            Schema::dropIfExists('applications');
	}

}
