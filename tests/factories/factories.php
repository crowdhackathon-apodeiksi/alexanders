<?php
$factory('App\Receipt', [
    'aa' => $faker->numberBetween(10000, 1000000),
    'afm' => $faker->numberBetween(100000000, 999999999),
    'eponimia' => array_rand(['Μασούτης', 'Μαρινόπουλος', 'Καφετέρια'], 1),
    'poso' => $faker->randomFloat(2, 1, 5000),
    'image' => array_rand(['http://www.xblog.gr/wp-content/uploads/2008/05/apodeiksi.jpg', 'http://www.protothema.gr/files/1/2014/07/28/apodeiksinolo123visi.jpg', 'https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcTBQ3IDHuRzS3wJfN0G-afhmPw-PcKuFfsWeFIzKJikVQZKENttbA'],1),
    'printed_at' => $faker->dateTime(),
    'user_id' => 1
]);
$factory('App\Category', [
    'name' => $faker->word,
    'user_id' => 1
]);
$factory('App\Promotion', [
    'title' => $faker->sentence(4),
    'type' => $faker->word,
    'receipts_count' => $faker->numberBetween(5, 20),
    'money_count' => $faker->numberBetween(5, 2000),
    'business_afm' => '509645501'
]);