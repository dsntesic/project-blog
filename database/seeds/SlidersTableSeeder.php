<?php

use Illuminate\Database\Seeder;
use App\Models\Slider;

class SlidersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sliders')->truncate();
        
        for($i = 1;$i<=10;$i++){
            factory(Slider::class)->create([
                'priority' => $i
            ]);
        }
    }
}
