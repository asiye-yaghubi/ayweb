<?php

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages = [ 
            [
                'title' => 'fa',
                'name' => 'فارسی',
                'status' => 'فعال'
            ],
            [
                'title' => 'en',
                'name' => 'english',
                'status' => 'فعال'
            ],
            
            
            
          ];

          foreach($languages as $language)
          {
              Language::create([
               'title' => $language['title'], 
               'name' => $language['name'],
               'status' => $language['status'],
             ]);
           }
    }
}
