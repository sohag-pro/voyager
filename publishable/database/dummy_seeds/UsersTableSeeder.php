<?php

use Illuminate\Support\Str;
use TCG\Voyager\Models\Role;
use TCG\Voyager\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder {
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run() {
        if ( User::count() == 0 ) {
            $role = Role::where( 'name', 'admin' )->firstOrFail();

            User::create( [
                'first_name'     => 'Super',
                'last_name'      => 'Admin',
                'email'          => 'super@admin.com',
                'password'       => bcrypt( 'password' ),
                'remember_token' => Str::random( 60 ),
                'role_id'        => $role->id,
            ] );
        }
    }
}
