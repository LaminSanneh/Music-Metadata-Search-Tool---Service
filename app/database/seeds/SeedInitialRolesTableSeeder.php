<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;
use \Role as Role;
class SeedInitialRolesTableSeeder extends Seeder {

	public function run()
	{
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::table('roles')->truncate();
		Role::create(
            array(
                'name' => 'Super User'
            )
        );

        Role::create(
            array(
                'name' => 'Regular User'
            )
        );

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
	}

}