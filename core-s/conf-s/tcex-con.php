<?php
$AppConfig = array (
        'db'                             => array (
                'webhost'                   => 'localhost',  // localhost
                'webuser'                   => '', // اسم مستخدم قاعده البيانات
                'webpassword'               => '', // باسورد قاعده البيانات
                'webdatabase'               => '', // اسم قاعده البيانات
                   ),
  				'paylink' => array (
                  	'apiId' => 'APP_ID_1647034999479',
                  	'secretKey' => '000e225b-e1d6-446c-afeb-5a58bf04cd26'
                ),
                'Game'                   => array (
                'speed'                  => '500',//سرعة اللعبة
                'WWW'                    => '1', // لا تعدل شىء
                'map'                    => '600',//حجم الخريطة يفضل 600
                'attack'                 => '20',//سرعة الهجوم
                'protection'             => '48',// الحمايه بالساعات
                'protectionx'            => '0',//تدبيل الحمايه
                'X'                      => '1328827643',
                'capacity'               => '100', // المخازن يفضل 60 
                'cranny'                 => '50', // المخابأ
                'cp'                     => '100',//طبيعيه 100
                '7maya'                  => '1',//شراء حماية 1 للتفعل و 0 للتعطيل
				'un7maya'                  => '1',//شراء الغاء الحماية 1 للتفعيل 0 للتعطيل
                'registerfailename'      => '1',  // لا تعدل شىء
                'market'                 => '30', // حمولة التجار
                'mkale'                  => '10', //القماليع 10 للتشغيل 30 للايقاف
				/////////////////////////////////////////////////////////////////
				//تاريخ بداية السيرفر وظهور التتار فى ملف اللوجن
				'starxxsmart'      => '00/00/0000',  // تاريخ بداية السيرفر
                'tatarxxsmart'     => '00/00/0000', // تاريخ ظهور التتار
				//////////////////////////////////////////////////////////////////
			

			   //البلاس
                'plus1'                  => '3',//مده بلاس بالايام
                'plus2'                  => '2',//مده الزياده بالايام
                'plus3'                  => '20',// عدد الذهب اللازم لتفعيل البلاس
                'plus4'                  => '5',// زيادة الموارد
                'plus5'                  => '2',//انهاء المباني فورأ
                'plus6'                  => '3',//تاجر مبادله
                'plus7'                  => '35',//انهاء تدريب الجنود
                'plus8'                  => '500',//نادي الذهب
				'activitebuyres'               => '0',// 1 شراء الموارد شغال 0 تعطيل
                'res'                          => '20000',// 1 شراء الموارد شغال 0 تعطيل
	//سوق المحاربين
                'soq'                    => '0',// 1 سوق المحاربين شغال 0 تعطيل
				//______ اسعار الجنود فى سوق المحاربين _______//
				 // قبيلة العرب
                'araab'                => '0.011',// رامي السهام
                'araab1'               => '0.0127',// محارب بشوكه
                'araab2'               => '0.0153',// الحارس 
                'araab3'                   => '0.0099',// طائر التجسس
                'araab4'                => '0.0327', // فارس العرب
                'araab5'              => '0.0485',//فارس الفؤوس
				'araab6'              => '0.05',//الكبش 
				'araab7'              => '0.074',//المنجنيق الناري
				// قبيلة الرومان
				'romaan'                => '0.008',// جندى أول الرومان
                'romaan1'               => '0.0076',// حراس الأمبراطور
                'romaan2'               => '0.011',// جندى مهاجم
				'romaan3'               => '0.0066',// فرقة التجسس
                'romaan4'                   => '0.025',// سلاح الفرسان
                'romaan5'                => '0.0397', // فرسان القيصر
				'romaan6'                => '0.0335', // الكبش
                'romaan7'              => '0.0548',//المقلاع
				// قبيلة الأغريق
				'greeec'                => '0.0057',// الكتيبه
                'greeec1'               => '0.0098',// المبارز
                'greeec2'               => '0.0069',// المستكشف
                'greeec3'                   => '0.0176',// رعد الاغريق
                'greeec4'                => '0.0199', // فرسان السلت
                'greeec5'              => '0.0360',//فرسان الهيدوانر
				'greeec6'              => '0.0350',//محطمة الابواب
				'greeec7'              => '0.0573',//المقلاع الحربي
				// قبيلة الجرمان
				'germaan'                => '0.0045',// مقاتل بهراوة
                'germaan1'               => '0.0062',// مقاتل برمح
                'germaan2'               => '0.00898',// مقاتل بفاس
                'germaan3'                   => '0.0066',// الكشاف
                'germaan4'                => '0.0184', // مقاتل القيصر
                'germaan5'              => '0.0279',//فرسان الجرمان
				'germaan6'              => '0.0315',//محطمة الابواب
				'germaan7'              => '0.0506',//المقلاع
                //امـور عامه
                'medalstime'             =>'345600',// كل 30 دقيقة = 1800 
                                                   // كل 1 ساعة = 3600
                                                  // كل 2 ساعة = 7200 
                                                 // كل 3 ساعة = 10800 
                                                // كل 4 ساعة = 14400 
                                               // كل 5 ساعة = 18000 
                                              // كل 6 ساعة = 21600 
                                             // كل 8 ساعة = 28800 
                                            // كل 12 ساعة = 43200 
                                           // كل 24 ساعة = 86400 
                                          // كل 2 أيام = 172800 
                                         // كل 3 أيام = 259200                                              
										// كل 4 أيام = 345600 
											 
                'osas'                   => '125',// الواحات العاديه
                'osasX'                  => '250',// الواحات الكبيره القمح 
                'online'                 => '5000',//المتصلين خروجهم بعد 
                'freegold'               => '1500',//ذهب مجاني عند التسجيل
                'wingold'                => '1',//تشغيل ربح الذهب 0 شغال و 1 غير شغال
                'pepolegold'             => '3',//كسب الذهب دعوة لاعب سكان استلام الذهب ؟
                'setgold'                => '1000',//كسب الذهب الذهب المعطى
                'RegisterOver'           => '300',//مدة اغلاق التسجيل عدد الايام
                'tatarover'              => '30',// موعد ضهةر التتار بالايام فقط
                   ),
                'page'                   => array (
                'ar_title'               => 'السيرفر الأول - حرب التتار',
                'meta-tag'               => 'حرب التتار،سيرفر حرب التتار،سيرفرات حرب التتار،سكربت حرب التتار،حرب التتار سمارت سيرفس،سكربت حرب التتار سمارت سيرفس،سكربت تتار،سكربتات حرب التتار،النسخه الكلاسيك سمارت سيرفس،سكربت ترافيان،سيرفرات ترافيان،ترافيان السريع،سيرفر حرب التتار السريع،سيرفر حرب التتار السعودى',
                'asset_version'          => 'Nhjkh1ka111alcMfks'
                   ),
                'system'                 => array (
                'adminName'              => 'admin', // اسم الادمن
                'adminPassword'          => '123123aa323', // باسورد الادمن
                'server_start'           => '2020/12/10 19:00:00', // 2014/16/06 18:00:00
                'lang'                   => 'ar',
                'admin_email'            => 'smartservs.com@gmail.com',
                'email'                  => 'smartservs.com@gmail.com',
                'namesite'               => 'حرب التتار',
                'linksite'               => 'https://tatarwars-ssv5le.smartservs.net/',
                'installkey'             => 'instaWE105R22221215412sghjkea',
                'calltatar'              => 'tatarsmWE10artsWE10s222123f1e2121', 
                'words'                  => array ( // كلمات محضوره Bad Word
                           array ( 'name'=> 'tatarx' ),
                           array ( 'name'=> 'taatarswar' ),
                           array ( 'name'=> 'tatar' ),
                           array ( 'name'=> 'com' ),
                           array ( 'name'=> 'COM' ),
                           array ( 'name'=> 'C O M' ),
                           array ( 'name'=> 'C  O  M' ),
                           array ( 'name'=> 'tatar' ),
                           array ( 'name'=> 'war' ),
                           array ( 'name'=> 'klay' ),
                           array ( 'name'=> 'net' ),
                           array ( 'name'=> 'org' ),
                           array ( 'name'=> 'us' ),
                           array ( 'name'=> 'es' ),
                           array ( 'name'=> 'elaml' ),
                           array ( 'name'=> 'tatar' ),
                           array ( 'name'=> 'server' ),
                           array ( 'name'=> 'war' ),
                           array ( 'name'=> 'سيرفر' ),
                           array ( 'name'=> 'حرب التتار' ),
                           array ( 'name'=> 'نيفرات' ),
                           array ( 'name'=> 'نيفارت' ),
                           array ( 'name'=> 'موفيان' ),
                           array ( 'name'=> 'neviart' ),
                           array ( 'name'=> 'Neviart' ),
                           array ( 'name'=> 'xtatar' ),
                           array ( 'name'=> 'kawaswer' ),
                           array ( 'name'=> 'HS12353' ),
                           array ( 'name'=> 'LY' ),
                           array ( 'name'=> 'الكواسر' ),
                           array ( 'name'=> 'كلاي وار' ),
                           array ( 'name'=> 'كرافيان' ),
                           array ( 'name'=> 'فرسان التتار' ),
                           array ( 'name'=> 't-66' ),
                           array ( 'name'=> 'fravian' ),
                           array ( 'name'=> 'tatars' ),
                           array ( 'name'=> 'tatarc' ),
                           array ( 'name'=> 'fursan' ),
                           array ( 'name'=> 'tatarz' ),
                           array ( 'name'=> 'travian' ),
                           array ( 'name'=> 'kravian' ),
                           array ( 'name'=> 'clone' ),
                           array ( 'name'=> 'ذكريات ترافيان' ),
                           array ( 'name'=> 'ذكــريــات تــرافـــيان' ),
                           array ( 'name'=> 'zVBrn' ),
                           array ( 'name'=> 'أمـــــراء تـــــرافـــيــــان' ),
                           array ( 'name'=> 'Ah4Z' ),
                           array ( 'name'=> 'أمــــــراء تــرافــيــــــان' ),
                           array ( 'name'=> 'قائمــة الــمــزارع' ),
                           array ( 'name'=> 'أمـــــــــراء تــرافــــــيــــــــان' ),
                           array ( 'name'=> 'BIt' ),
                           array ( 'name'=> 'ترافيان العربية' ),
                           array ( 'name'=> 'جايزة المعجزه ١٠٠٠ ريال' ),
                           array ( 'name'=> 'اربح 1000 ريال سعودي' ),
                           array ( 'name'=> 't' ),
                           array ( 'name'=> 't_r_a_v_i_a' ),
                           array ( 'name'=> 'السيرفر الثاني و' ),
                           array ( 'name'=> 'tc4' ),
                           array ( 'name'=> 'tc5' ),
                           array ( 'name'=> 'tc6' ),
                           array ( 'name'=> 'x1' ),
                           array ( 'name'=> 'x2' ),
                           array ( 'name'=> 'gd' ),
                           array ( 'name'=> 'is' ),
                           array ( 'name'=> 'cutt' ),
                           array ( 'name'=> 'أمـــــراء ترافيــــــــان' ),
                           array ( 'name'=> 'is' ),
                           array ( 'name'=> 'is' ),
                           array ( 'name'=> 'is' ),
                           array ( 'name'=> 'NB7Cf3' ),
                           array ( 'name'=> 'x4' ),
                           array ( 'name'=> 'x5' ),
                           array ( 'name'=> 'o mra' ),
                           array ( 'name'=> 'soo' ),
                           array ( 'name'=> 'me lde' ),
                           array ( 'name'=> 'ph p' ),
                           array ( 'name'=> 'ra vian' ),
                           array ( 'name'=> 'serv1' ),
                           array ( 'name'=> 'serv2' ),
                           array ( 'name'=> 'serv3' ),
                           array ( 'name'=> 'serv4' ),
                           array ( 'name'=> 'serv5' ),
                           array ( 'name'=> 'php' ),
                           array ( 'name'=> 'login' ),
                           array ( 'name'=> 'www' ),
                           array ( 'name'=> 'tiny' ),
                           array ( 'name'=> 'http' ),
                           array ( 'name'=> 'BiT' ),
                           array ( 'name'=> 'CuTt' ),
                           array ( 'name'=> 'wFVz' ),
                           array ( 'name'=> 'register' ),
                           array ( 'name'=> 'ترافـيانـكو' ),
                           array ( 'name'=> 't r a v i a n c o' ),
                           array ( 'name'=> 'ABMI' ),
                           array ( 'name'=> 'Bit' ),
                           array ( 'name'=> 'soO' ),
                           array ( 'name'=> 'biT' ),
                           array ( 'name'=> 'تــرافــيــانكو' ),
                           array ( 'name'=> 'ترافيانكو' ),
                           array ( 'name'=> 'أمــــر اء تــــرا فـــيـــان' ),
                           array ( 'name'=> 'أمراء ترافيان' ),
                           array ( 'name'=> 'PmbT' ),
                           array ( 'name'=> 'te3Ne' ),
                           array ( 'name'=> 'cUTT' ),
                           array ( 'name'=> 'SOo' ),
                           array ( 'name'=> 'tRAvIAnCo' ),
                           array ( 'name'=> 'DSAI' ),
                           array ( 'name'=> 'sOO' ),
                           array ( 'name'=> 'bIT' ),
                           array ( 'name'=> 'VJ2D' ),
                           array ( 'name'=> 'avzse' ),
                           array ( 'name'=> 'tra' ),
                           array ( 'name'=> 'ترافـيـانـكـو' ),
                           array ( 'name'=> 'ازل الفواصل' ),
                           array ( 'name'=> 'SmVr' ),
                           array ( 'name'=> '2G3P8ek' ),
                           array ( 'name'=> 'tmhP' ),
                           array ( 'name'=> 'N9' ),
                           array ( 'name'=> 'F24' ),
                           array ( 'name'=> 'ذكـــريــات تــرافــيــان' ),
                           array ( 'name'=> ' ذكـــريــات تــرافــيــان' ),
                           array ( 'name'=> 'ذكريــات ترافيــــان' ),
                           array ( 'name'=> '●الـواحـة الذهبـيــة' ),
                           array ( 'name'=> 'AQztT' ),
                           array ( 'name'=> 'AQztT' ),
                           array ( 'name'=> 'tmhP' ),
                           array ( 'name'=> 'J86yh' ),
                           array ( 'name'=> 'eNr5BS' ),
                           array ( 'name'=> 'TBtA' ),
                           array ( 'name'=> 'GR9337' ),
                           array ( 'name'=> 'yjGb' ),
                           array ( 'name'=> 'tawr' ),
                           array ( 'name'=> 'twar' ),
                           array ( 'name'=> 'speed' ),
                           array ( 'name'=> 'tatarz' ),
                           array ( 'name'=> 'hiHU' ),
                           array ( 'name'=> 'HS12353' ),
                           array ( 'name'=> 'tatarx' ),
                           array ( 'name'=> 'tatarc' ),
                           array ( 'name'=> 'BhcMoT' ),
                           array ( 'name'=> 'cUtt' ),
                           array ( 'name'=> '2U' ),
                           array ( 'name'=> 'ذكـــريـــــات تــــرافــيـــان' ),
                           array ( 'name'=> 'ravi' ),
                           array ( 'name'=> 'T' ),
                           array ( 'name'=> 'mel' ),
                           array ( 'name'=> 'goo' ),
                           array ( 'name'=> 'w5Di' ),
                           array ( 'name'=> 'aRXXz' ),
                           array ( 'name'=> 'yUIx' ),
                           array ( 'name'=> 'FYHq' ),
                           array ( 'name'=> 'sOo' ),
                           array ( 'name'=> 'cUtT' ),
                           array ( 'name'=> 'bIt' ),
                           array ( 'name'=> 'war' ),
                           array ( 'name'=> 'SOO' ),
                           array ( 'name'=> 'CUTT' ),
                           array ( 'name'=> 'jwYB' ),
                           array ( 'name'=> 'أمــــراء تــــرافـــيـــان' ),
                           array ( 'name'=> 'ذكـريــات تــــرافـــيـــان' ),
                           array ( 'name'=> 'أمــراء تــرافــيــان' ),
                           array ( 'name'=> 'ppvJk' ),
                           array ( 'name'=> 'bit' ),
                           array ( 'name'=> 'ذكـــريات ترافــــيـان' ),
                           array ( 'name'=> 'klay' ),
                           array ( 'name'=> '2Jr06R0' ),
                           array ( 'name'=> '17dB' ),
                           array ( 'name'=> 'IWfHM' ),
                           array ( 'name'=> 'traviany' ),
                           array ( 'name'=> 'CUTt' ),
                           array ( 'name'=> 'ذكريات ترافــيـان' ),
                           array ( 'name'=> 'fMbEa' ),
                           array ( 'name'=> 'vO3m' ),
                           array ( 'name'=> '2tatarx' ),
                           array ( 'name'=> 'com' ),
                           array ( 'name'=> 'html' ),
                           array ( 'name'=> 'ref' ),
                           array ( 'name'=> 'nJwe' ),
                           array ( 'name'=> 'dnu3' ),
                           array ( 'name'=> 'GM12343' ),
                           array ( 'name'=> 'ujZvk6' ),
                           array ( 'name'=> 'www' ),
                           array ( 'name'=> 't506' ),
                           array ( 'name'=> 'htatar' ),
                           array ( 'name'=> 'bsgm' ),
                           array ( 'name'=> '1mXhe' ),
                           array ( 'name'=> '2GY9Lwd' ),
                           array ( 'name'=> 'htatar' ),
                           array ( 'name'=> 'سـجـل والعـب الان مبـاشر لايفوتكك' ),
                           array ( 'name'=> 'على 50 مليون من القوات' ),
                           array ( 'name'=> 'CuTt' ),
                           array ( 'name'=> 'zZ9a' ),
                           array ( 'name'=> 'BiT' ),
                           array ( 'name'=> 'SoO' ),
                           array ( 'name'=> '40 ملـيـون من الـقـوات هـدية لـكـل لاعـب !' ),
                           array ( 'name'=> '(جـائـزة الفائـز بالمعـجزة 600000 ذهبة)' ),
                           array ( 'name'=> '20 مليون من القوات' ),
                           array ( 'name'=> 'رواابط مختصرره' ),
                           array ( 'name'=> 'السلام عليكم سجـل الان ' ),
                           array ( 'name'=> 'سـرعـة السـيرفـر X500' ),
                           array ( 'name'=> 'lYTh' ),
                           array ( 'name'=> 'Zzo9l' ),
                           array ( 'name'=> '2qw8pi4' ),
                           array ( 'name'=> 'ســجــل والعب مباشر الان 50 مليووون' ),
                           array ( 'name'=> 'كـل لاعـب يحصل على 50 مليـون من القـوات هـدية' ),
                           

                  )
                 ),

       'plus'                                  => array (

                'packages'                     => array (

                        /*array (

                                'name'         => 'sms',

                                'gold'         => 2000,

                                'cost'         => 10,

                                'plus'         => 0,

                                'currency'     => 'ريال',

                                'image'        => 'sms.png'

                        ),*/



			array ( 

				'name'		=> 'الأولى',

				'gold'		=> 110000,

				'goldplus'	=> 150000,

				'plus'		=> 20,

				'cost'		=> 25.00,

				'costplus'	=> 25.00,

				'currency'	=> 'usd',

				'image'		=> 'package_a.jpg'

			),

			array ( 

				'name'		=> 'الثانية',

				'gold'		=> 200000,

				'goldplus'	=> 300000,

				'plus'		=> 30,

				'cost'		=> 53.33,

				'costplus'	=> 53.33,

				'currency'	=> 'usd',

				'image'		=> 'package_b.jpg'

			),

			array ( 

				'name'		=> 'الثالثة',

				'gold'		=> 457000,

				'goldplus'	=> 600000,

				'plus'		=> 40,

				'cost'		=> 106.65,

				'costplus'	=> 106.65,

				'currency'	=> 'usd',

				'image'		=> 'package_c.jpg'

			),

			array ( 

				'name'		=> 'الرابعة',

				'gold'		=> 800000,

				'goldplus'	=> 1200000,

				'plus'		=> 50,

				'cost'		=> 213.29,

				'costplus'	=> 213.29,

				'currency'	=> 'usd',

				'image'		=> 'package_c.jpg'

			),

			array ( 

				'name'		=> 'الخامسة',

				'gold'		=> 2200000,

				'goldplus'	=> 3000000,

				'plus'		=> 80,

				'cost'		=> 533.3,

				'costplus'	=> 533.3,

				'currency'	=> 'usd',

				'image'		=> 'package_c.jpg'

            ),

            			array ( 

				'name'		=> 'السادسة',

				'gold'		=> 4700000,

				'goldplus'	=> 6000000,

				'plus'		=> 130,

				'cost'		=> 1066.5,

				'costplus'	=> 1066.5,

				'currency'	=> 'usd',

				'image'		=> 'package_c.jpg'
				

            ),
			            			array ( 

				'name'		=> 'السابعة',

				'gold'		=> 4700000,

				'goldplus'	=> 6000000,

				'plus'		=> 130,

				'cost'		=> 1066.5,

				'costplus'	=> 1066.5,

				'currency'	=> 'usd',

				'image'		=> 'package_c.jpg'

            ),

            			array ( 

				'name'		=> 'الثامنة',

				'gold'		=> 4700000,

				'goldplus'	=> 6000000,

				'plus'		=> 130,

				'cost'		=> 1066.5,

				'costplus'	=> 1066.5,

				'currency'	=> 'usd',

				'image'		=> 'package_c.jpg'

            ),


                ),

                'payments'                     => array (

                        'paypal'               => array (

                                'testMode'     => false,

                                'name'         => 'PayPal',
 
                                'image'        => 'PayPal-logo-1.png',

				'merchant_id'	=> 'c@smartservs.com',

				'currency'		=> 'USD'

                        ),
                        'paylink'	=> array (
				'testMode'		=> false,
				'name'			=> 'Visa | Mastercard | Mada',
				'image'			=> 'paylink.jpg',
				'merchant_id'	=> '',
				'currency'		=> 'USD'
				),
                        'apple_pay'	=> array (
				'testMode'		=> false,
				'name'			=> 'Apple Pay',
				'image'			=> 'apple.jpg',
				'merchant_id'	=> '',
				'currency'		=> 'USD'
				)



                )

        )



);

?>