<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BillsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = DB::table('users')->first();
        
        foreach (range(1,5) as $num) {
            DB::table('bills')->insert([
                'title' => "{$num}00gの豚肉と醤油、みりんを買いました",
                'total' => 400,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_id' => $user->id,
            ]);
        }
    }
}
