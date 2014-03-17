<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;
use \User as user;
use \Role as Role;
class SeedAdminUserTableSeeder extends Seeder {

	public function run()
	{
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::table('users')->truncate();
        DB::table('role_user')->truncate();

		if(DB::table('users')->where('email','lamin.evra@gmail.com')->count() == 0){
            $user = User::create(array(
                'first_name' => 'Lamin',
                'last_name' => 'Sanneh',
                'email' => 'lamin.evra@gmail.com',
                'password' => Hash::make('vicecity'),
                'confirmed' => true,
                'email_confirm_token' => ''
            ));

            DB::statement('SET FOREIGN_KEY_CHECKS = 1');
            $superUserRoleId = Role::where('name','LIKE',"%super%")->first(array('id'))->id;
            $user->addRole($superUserRoleId)->save();
        }
        else{
            echo "User already exists";
        }


	}

}