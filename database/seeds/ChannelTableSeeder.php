<?php

use Illuminate\Database\Seeder;

class ChannelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('channel')->delete();
        $data = [
                    [ 'id' => 1, 'name'  => 'สินค้าและบริการ' ,'slug'  => 'product-services' ],
                    [ 'id' => 2, 'name'  => 'อาหารการกิน' ,  'slug'  => 'food-and-dining' ],
                    [ 'id' => 3, 'name'  => 'ที่พักอาศัย' ,    'slug'  => 'living' ],
                    [ 'id' => 4, 'name'  => 'อยู่ต่างประเทศ' , 'slug'  => 'expat' ],
                    [ 'id' => 5, 'name'  => 'ท่องเที่ยว' ,     'slug'  => 'travel' ],
                    [ 'id' => 6, 'name'  => 'ภาพยนฅร์' ,    'slug'  => 'movie' ],
                    [ 'id' => 7, 'name'  => 'หนังสือ' ,      'slug'  => 'books' ],
                    [ 'id' => 8, 'name'  => 'เพลง คนดรี' ,  'slug'  => 'music' ],
                    [ 'id' => 9, 'name'  => 'ครอบครัว' ,    'slug'  => 'family' ],
                    [ 'id' => 10,'name'  => 'ข่าว' ,        'slug'  => 'news' ],
                    [ 'id' => 11,'name'  => 'เศรษฐกิจ' ,    'slug'  => 'finance' ],
                    [ 'id' => 12,'name'  => 'ธุรกิจ' ,       'slug'  => 'business' ],
                    [ 'id' => 13,'name'  => 'โทรศัพท์มือถือ', 'slug'  => 'mobile' ],
                    [ 'id' => 14,'name'  => 'เขียนโปรแกรม', 'slug'  => 'programming' ],
                    [ 'id' => 15,'name'  => 'ออกกำลังกาย', 'slug'  => 'workout' ],


                    [ 'id' => 99,'name'  => 'อื่นๆ',        'slug'  => 'others' ],
                ];
        DB::table('channel')->insert($data);
    }
}
