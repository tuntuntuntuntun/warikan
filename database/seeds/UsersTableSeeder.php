<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = ['nagase', 'matsumoto', 'aiba', 'sakurai'];

        foreach ($names as $name) {
            DB::table('users')->insert([
                'name' => $name,
                'email' => "{$name}@{$name}.com",
                'password' => bcrypt('testtest'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
