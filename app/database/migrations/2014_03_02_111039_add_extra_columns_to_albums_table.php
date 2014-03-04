<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddExtraColumnsToAlbumsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('albums', function(Blueprint $table) {
			$table->date('release_year')->nullable();
			$table->string('genre')->nullable();
			$table->string('notes')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('albums', function(Blueprint $table) {
            $table->dropColumn('release_year');
            $table->dropColumn('genre');
            $table->dropColumn('notes');
		});
	}

}
