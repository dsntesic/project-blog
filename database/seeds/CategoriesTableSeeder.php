<?php

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->truncate();
        for($i = 1;$i<=5;$i++){
            factory(Category::class)->create([
                'priority' => $i
            ]);
        }
    }
}
