<?php

namespace Database\Seeders;

use App\Models\notifi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Video;

class notifiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $notifi1 = notifi::create([
            'user_id' => User::where('name', 'hsoub-academy')->first()->id,
            'notifi' => Video::where('title', 'دورة علوم الحاسوب - أكاديمية حسوب')->first()->title,
            'success' => '1',
        ]);

        $notifi2 = notifi::create([
            'user_id' => User::where('name', 'hsoub-academy')->first()->id,
            'notifi' => Video::where('title', 'دورة تطوير واجهات المستخدم - أكاديمية حسوب')->first()->title,
            'success' => '0',
        ]);

        $notifi3 = notifi::create([
            'user_id' => User::where('name', 'hsoub-academy')->first()->id,
            'notifi' => Video::where('title', 'دورة تطوير واجهات المستخدم - أكاديمية حسوب')->first()->title,
            'success' => '1',
        ]);

        $notifi4 = notifi::create([
            'user_id' => User::where('name', 'hsoub')->first()->id,
            'notifi' => Video::where('title', 'دورة تطوير الويب باستخدام لغة جافاسكريبت')->first()->title,
            'success' => '1',
        ]);

        $notifi5 = notifi::create([
            'user_id' => User::where('name', 'hsoub')->first()->id,
            'notifi' => Video::where('title', 'دورة تطوير تطبيقات الهاتف باستخدام Cordova')->first()->title,
            'success' => '1',
        ]);

        $notifi6 = notifi::create([
            'user_id' => User::where('name', 'Mostaql')->first()->id,
            'notifi' => Video::where('title', 'خمسة نصائح لاختيار أفضل المستقلين للعمل على مشروعك')->first()->title,
            'success' => '1',
        ]);

        $notifi7 = notifi::create([
            'user_id' => User::where('name', 'Khamsat')->first()->id,
            'notifi' => Video::where('title', 'اعرض خدماتك في أكبر سوق عربي لعرض وشراء الخدمات المصغرة')->first()->title,
            'success' => '1',
        ]);

        $notifi8 = notifi::create([
            'user_id' => User::where('name', 'Baeed')->first()->id,
            'notifi' => Video::where('title', 'وظف أفضل المستقلين الموجودين في الوطن العربي عن بعد')->first()->title,
            'success' => '1',
        ]);
    }
}
