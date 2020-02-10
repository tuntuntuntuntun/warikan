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
        foreach (range(1,5) as $num) {
            DB::table('bills')->insert([
                'to_user_id' => '2,3,4',
                'title' => "{$num}00gの豚肉と醤油、みりんを買いました",
                'total' => 400,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
