<?php

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguagesTableSeeder extends Seeder
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
                'title' => 'English',
                'locale' => 'en',
            ],
            [
                'title' => 'عربي',
                'locale' => 'ar',
            ],
            [
                'title' => 'francais',
                'locale' => 'fr',
            ],
        ];
        Language::insert($languages);
    }
}
