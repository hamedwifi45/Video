<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Views;
use App\Models\User;
use App\Models\Video;

class ViewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $view1 = Views::create([
            'user_id' => User::where('name', 'hsoub-academy')->first()->id,
            'video_id' => Video::where('title', 'دورة علوم الحاسوب - أكاديمية حسوب')->first()->id,
            'Views_number' => '70',
        ]);

        $Views2 = Views::create([
            'user_id' => User::where('name', 'hsoub-academy')->first()->id,
            'video_id' => Video::where('title', 'دورة تطوير واجهات المستخدم - أكاديمية حسوب')->first()->id,
            'Views_number' => '40',
        ]);

        $Views3 = Views::create([
            'user_id' => User::where('name', 'hsoub')->first()->id,
            'video_id' => Video::where('title', 'دورة تطوير الويب باستخدام لغة جافاسكريبت')->first()->id,
            'Views_number' => '45',
        ]);

        $Views4 = Views::create([
            'user_id' => User::where('name', 'hsoub')->first()->id,
            'video_id' => Video::where('title', 'دورة تطوير تطبيقات الهاتف باستخدام Cordova')->first()->id,
            'Views_number' => '58',
        ]);

        $Views5 = Views::create([
            'user_id' => User::where('name', 'Mostaql')->first()->id,
            'video_id' => Video::where('title', 'خمسة نصائح لاختيار أفضل المستقلين للعمل على مشروعك')->first()->id,
            'Views_number' => '20',
        ]);

        $Views6 = Views::create([
            'user_id' => User::where('name', 'Khamsat')->first()->id,
            'video_id' => Video::where('title', 'اعرض خدماتك في أكبر سوق عربي لعرض وشراء الخدمات المصغرة')->first()->id,
            'Views_number' => '67',
        ]);

        $Views7 = Views::create([
            'user_id' => User::where('name', 'Baeed')->first()->id,
            'video_id' => Video::where('title', 'وظف أفضل المستقلين الموجودين في الوطن العربي عن بعد')->first()->id,
            'Views_number' => '15',
        ]);
    }
}
