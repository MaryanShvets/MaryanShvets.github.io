<?

include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');

$list = $_GET['list'];

$list = 'opened_'.$list;

MySQL::connect();

$mysql = " SELECT COUNT(DISTINCT(`key5`)) as `count`  FROM `app_pulse` WHERE `key4` = '$list' AND `key5` IN (
'7ostrik7@mail.ru',
'81-13@mail.ru',
'a-anciferova@list.ru',
'aigu84@mail.ru',
'ak47tt@gmail.com',
'akonyaakinbekova@gmail.com',
'alenastrij@yandex.ru',
'alevtina.kudryashova.62@mail.ru',
'alla_lobatch@mail.ru',
'andronova_tanechka@mail.ru',
'belonogovatn@yandex.ru',
'bileva_masha85@mail.ru',
'borzova8484@mail.ru',
'brilevskaja@inbox.lv',
'c.belaya2010@yandex.ru',
'domikgeorgia@mail.ru',
'elena-abramova96@mail.ru',
'fedotova.mgn@yandex.ru',
'fialka1978@mail.ru',
'Frolchinkova@yandex.ru',
'galinis_ann@mail.ru',
'girchenko_olga@rambler.ru',
'Gulnaz16f@mail.ru',
'inkeroinen91@yandex.ru',
'Irina-shutowa@mail.ru',
'irina.fox@bk.ru',
'IrinaSarakeieva@ukr.net',
'jenyatarasova@mail.ru',
'jusja_777@mail.ru',
'k.semchuk@rambler.ru',
'Kamilla.orumbaeva@mail.ru',
'katya_katerin96@mail.ru',
'katykama@mail.ru',
'kom-liliya@yandex.ru',
'kostelek.17@mail.ru',
'krickon088@gmail.com',
'ksudor@mail.ru',
'Ksuhesa23@mail.ru',
'ktanja64@gmail.com',
'leskommvika@mail.ru',
'lusa89@bk.ru',
'Lykova_i@bk.ru',
'marig87@list.ru',
'masha_198716@mail.ru',
'mazitovaliliya@mail.ru',
'median.90@mail.ru',
'melhi93_94@mail.ru',
'miss.nastroenie17@yandex.ru',
'misszari617@gmail.com',
'nade-kravchuk@yandex.ru',
'Nakkozlova@icloud.com',
'nat5917@yandex.ru',
'natashka.berezina7@mail.ru',
'nysyakorzh@yandex.ru',
'olesy050381@gmail.com',
'olgaefrem@rambler.ru',
'olgazaplava321@gmail.com',
'polinaroman2604@gmail.com',
'rayalyalikova51@yandex.ru',
'rega.malishka@gmail.com',
'sandrea@ngs.ru',
'shikovadiana98@gmail.com',
'starry_heart@mail.ru',
'sveric@mail.ru',
't-oil154@mail.ru',
'taliiamail@icloud.com',
'tata-911ta@mail.ru',
'tatam2103@gmail.com',
'tatmalyg75@mail.ru',
'veronicademidovitch@gmail.com',
'vlada.alekseeva.2013@bk.ru',
'votinceva_y@mail.ru',
'yana.sitnikova1234@mail.ru',
'zapovednik@gmail.com',
'Zhadan-anna@mail.ru'
) ";

print_r(MySQL::query($mysql));



?>