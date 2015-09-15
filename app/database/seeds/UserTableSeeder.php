<?php

class UserTableSeeder extends Seeder {

	public function run()
	{
		$user = new User();
        $user->nit = '1116786822';
        $user->nombre = 'Daniel Guillermo Romero Gelvez';
        $user->email = 'danielromeroauk@gmail.com';
        $user->password = Hash::make('111111');
        $user->save();
	}

}