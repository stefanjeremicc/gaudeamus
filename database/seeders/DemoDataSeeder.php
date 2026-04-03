<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\Company;
use App\Models\EmployerProfile;
use App\Models\JobListing;
use App\Models\Page;
use App\Models\StudentProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        $admin = User::create([
            'name' => 'Admin Gaudeamus',
            'email' => 'admin@gaudeamus.rs',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'locale' => 'sr',
            'email_verified_at' => now(),
        ]);

        // Companies
        $companies = [
            Company::create([
                'name' => 'TechCorp Solutions',
                'slug' => 'techcorp-solutions',
                'description' => ['sr' => 'Vodeća IT kompanija u Srbiji specijalizovana za web razvoj.', 'en' => 'Leading IT company in Serbia specialized in web development.', 'ru' => 'Ведущая IT компания в Сербии, специализирующаяся на веб-разработке.'],
                'website' => 'https://techcorp.rs',
                'pib' => '123456789',
                'city' => 'Beograd',
                'region_id' => 1,
                'is_verified' => true,
            ]),
            Company::create([
                'name' => 'CafeX',
                'slug' => 'cafex',
                'description' => ['sr' => 'Lanac modernih kafića širom Srbije.', 'en' => 'Chain of modern cafes across Serbia.', 'ru' => 'Сеть современных кафе по всей Сербии.'],
                'city' => 'Novi Sad',
                'region_id' => 2,
                'is_verified' => true,
            ]),
            Company::create([
                'name' => 'MarketPro Agency',
                'slug' => 'marketpro-agency',
                'description' => ['sr' => 'Digitalna marketing agencija sa fokusom na performans marketing.', 'en' => 'Digital marketing agency focused on performance marketing.', 'ru' => 'Агентство цифрового маркетинга.'],
                'city' => 'Beograd',
                'region_id' => 1,
                'is_verified' => true,
            ]),
            Company::create([
                'name' => 'LogiSerb d.o.o.',
                'slug' => 'logiserb',
                'description' => ['sr' => 'Logistička kompanija sa magacinima u Beogradu i Nišu.', 'en' => 'Logistics company with warehouses in Belgrade and Nis.', 'ru' => 'Логистическая компания со складами в Белграде и Нише.'],
                'city' => 'Beograd',
                'region_id' => 1,
                'is_verified' => true,
            ]),
            Company::create([
                'name' => 'EduStar Centar',
                'slug' => 'edustar-centar',
                'description' => ['sr' => 'Obrazovni centar za decu i odrasle.', 'en' => 'Educational center for children and adults.', 'ru' => 'Образовательный центр для детей и взрослых.'],
                'city' => 'Kragujevac',
                'region_id' => 4,
                'is_verified' => true,
            ]),
        ];

        // Employer users
        foreach ($companies as $i => $company) {
            $employer = User::create([
                'name' => 'Poslodavac ' . $company->name,
                'email' => 'employer' . ($i + 1) . '@gaudeamus.rs',
                'password' => Hash::make('password'),
                'role' => 'employer',
                'locale' => 'sr',
                'email_verified_at' => now(),
            ]);
            EmployerProfile::create([
                'user_id' => $employer->id,
                'company_id' => $company->id,
                'position' => 'HR Manager',
            ]);
        }

        // Student users
        $student1 = User::create([
            'name' => 'Marko Petrović',
            'email' => 'student@gaudeamus.rs',
            'password' => Hash::make('password'),
            'role' => 'student',
            'locale' => 'sr',
            'email_verified_at' => now(),
        ]);
        StudentProfile::create([
            'user_id' => $student1->id,
            'employment_status' => 'student',
            'university' => 'Univerzitet u Beogradu',
            'faculty' => 'Elektrotehnički fakultet',
            'year_of_study' => 3,
            'city' => 'Beograd',
            'region_id' => 1,
            'is_active_member' => true,
            'cooperative_member_since' => now()->subMonths(6),
        ]);

        // Job Listings
        $jobs = [
            [
                'company_id' => $companies[0]->id,
                'created_by' => 2,
                'title' => ['sr' => 'Junior Web Developer', 'en' => 'Junior Web Developer', 'ru' => 'Младший веб-разработчик'],
                'slug' => 'junior-web-developer-beograd',
                'description' => ['sr' => 'Tražimo motivisanog studenta za poziciju junior web developera. Rad na modernim web projektima koristeći Laravel i Vue.js. Mogućnost fleksibilnog radnog vremena prilagođenog rasporedu predavanja.', 'en' => 'We are looking for a motivated student for a junior web developer position. Work on modern web projects using Laravel and Vue.js.', 'ru' => 'Ищем мотивированного студента на позицию младшего веб-разработчика.'],
                'requirements' => ['sr' => 'Poznavanje HTML, CSS, JavaScript. Poželjno iskustvo sa PHP/Laravel. Git osnove.', 'en' => 'Knowledge of HTML, CSS, JavaScript. PHP/Laravel experience preferred. Git basics.', 'ru' => 'Знание HTML, CSS, JavaScript.'],
                'job_category_id' => 1,
                'region_id' => 1,
                'city' => 'Beograd',
                'positions_count' => 3,
                'hourly_rate_min' => 450,
                'hourly_rate_max' => 600,
                'working_hours_per_week' => 20,
                'shift_type' => 'flexible',
                'ad_type' => 'part_time',
                'employment_status_required' => 'student',
                'is_featured' => true,
                'status' => 'active',
                'published_at' => now()->subDays(2),
                'expires_at' => now()->addDays(28),
            ],
            [
                'company_id' => $companies[1]->id,
                'created_by' => 3,
                'title' => ['sr' => 'Konobar/ica', 'en' => 'Waiter/Waitress', 'ru' => 'Официант/ка'],
                'slug' => 'konobar-novi-sad',
                'description' => ['sr' => 'CafeX traži energične konobari/ce za rad u našim kafićima u Novom Sadu. Prijatna radna atmosfera i mogućnost rada vikendom.', 'en' => 'CafeX is looking for energetic waiters/waitresses for our cafes in Novi Sad.', 'ru' => 'CafeX ищет энергичных официантов/официанток.'],
                'requirements' => ['sr' => 'Komunikativnost, odgovornost, pozitivan stav. Nije potrebno iskustvo - obezbeđujemo obuku.', 'en' => 'Good communication, responsibility, positive attitude. No experience needed.', 'ru' => 'Коммуникабельность, ответственность.'],
                'job_category_id' => 2,
                'region_id' => 2,
                'city' => 'Novi Sad',
                'positions_count' => 5,
                'hourly_rate_min' => 300,
                'hourly_rate_max' => 400,
                'working_hours_per_week' => 24,
                'shift_type' => 'flexible',
                'ad_type' => 'part_time',
                'employment_status_required' => 'both',
                'is_featured' => true,
                'status' => 'active',
                'published_at' => now()->subDays(1),
                'expires_at' => now()->addDays(21),
            ],
            [
                'company_id' => $companies[2]->id,
                'created_by' => 4,
                'title' => ['sr' => 'Social Media Asistent', 'en' => 'Social Media Assistant', 'ru' => 'Ассистент по социальным сетям'],
                'slug' => 'social-media-asistent-beograd',
                'description' => ['sr' => 'Potreban nam je kreativan student za upravljanje društvenim mrežama naših klijenata. Rad od kuće, fleksibilno radno vreme.', 'en' => 'We need a creative student to manage social media for our clients. Work from home, flexible hours.', 'ru' => 'Нужен креативный студент для управления соцсетями.'],
                'requirements' => ['sr' => 'Iskustvo sa Instagram, TikTok, Facebook. Kreativnost. Poznavanje Canve ili sličnih alata.', 'en' => 'Experience with Instagram, TikTok, Facebook. Creativity. Knowledge of Canva.', 'ru' => 'Опыт работы с Instagram, TikTok, Facebook.'],
                'job_category_id' => 3,
                'region_id' => 1,
                'city' => 'Beograd',
                'positions_count' => 2,
                'hourly_rate_min' => 350,
                'hourly_rate_max' => 500,
                'working_hours_per_week' => 15,
                'shift_type' => 'flexible',
                'ad_type' => 'part_time',
                'employment_status_required' => 'student',
                'is_featured' => true,
                'status' => 'active',
                'published_at' => now()->subDays(3),
                'expires_at' => now()->addDays(14),
            ],
            [
                'company_id' => $companies[3]->id,
                'created_by' => 5,
                'title' => ['sr' => 'Magacioner', 'en' => 'Warehouse Worker', 'ru' => 'Кладовщик'],
                'slug' => 'magacioner-beograd',
                'description' => ['sr' => 'LogiSerb traži magacionere za rad u magacinu na Novom Beogradu. Jutarnja smena, redovna isplata.', 'en' => 'LogiSerb is looking for warehouse workers in New Belgrade. Morning shift, regular payment.', 'ru' => 'LogiSerb ищет кладовщиков для работы на складе в Нови-Белграде.'],
                'requirements' => ['sr' => 'Fizička sposobnost, tačnost, pouzdanost. Poželjno iskustvo sa viljuškarom.', 'en' => 'Physical fitness, punctuality, reliability. Forklift experience preferred.', 'ru' => 'Физическая подготовка, пунктуальность.'],
                'job_category_id' => 4,
                'region_id' => 1,
                'city' => 'Beograd',
                'positions_count' => 8,
                'hourly_rate_min' => 350,
                'hourly_rate_max' => 450,
                'working_hours_per_week' => 40,
                'shift_type' => 'morning',
                'ad_type' => 'full_time',
                'employment_status_required' => 'both',
                'is_featured' => false,
                'status' => 'active',
                'published_at' => now()->subHours(12),
                'expires_at' => now()->addDays(30),
            ],
            [
                'company_id' => $companies[4]->id,
                'created_by' => 6,
                'title' => ['sr' => 'Predavač engleskog jezika', 'en' => 'English Language Teacher', 'ru' => 'Преподаватель английского'],
                'slug' => 'predavac-engleskog-kragujevac',
                'description' => ['sr' => 'EduStar traži studente anglistike za časove engleskog jezika za decu od 6-12 godina. Popodnevna smena.', 'en' => 'EduStar is looking for English language students to teach children ages 6-12. Afternoon shift.', 'ru' => 'EduStar ищет студентов-англистов для преподавания детям 6-12 лет.'],
                'requirements' => ['sr' => 'Student anglistike ili srodnog smera. Strpljivost, ljubav prema deci. B2+ nivo engleskog.', 'en' => 'English language student. Patience, love for children. B2+ English level.', 'ru' => 'Студент-англист. Терпение, любовь к детям.'],
                'job_category_id' => 8,
                'region_id' => 4,
                'city' => 'Kragujevac',
                'positions_count' => 2,
                'hourly_rate_min' => 500,
                'hourly_rate_max' => 700,
                'working_hours_per_week' => 10,
                'shift_type' => 'afternoon',
                'ad_type' => 'part_time',
                'employment_status_required' => 'student',
                'is_featured' => true,
                'status' => 'active',
                'published_at' => now()->subDays(5),
                'expires_at' => now()->addDays(20),
            ],
            [
                'company_id' => $companies[0]->id,
                'created_by' => 2,
                'title' => ['sr' => 'QA Tester (Manual)', 'en' => 'QA Tester (Manual)', 'ru' => 'QA тестировщик'],
                'slug' => 'qa-tester-manual-beograd',
                'description' => ['sr' => 'Tražimo studenta za manuelno testiranje web aplikacija. Mogućnost rada od kuće i fleksibilan raspored.', 'en' => 'Looking for a student for manual testing of web applications. Remote work possible.', 'ru' => 'Ищем студента для ручного тестирования веб-приложений.'],
                'requirements' => ['sr' => 'Analitički um, pažnja na detalje. Osnovno poznavanje web tehnologija.', 'en' => 'Analytical mindset, attention to detail. Basic web technology knowledge.', 'ru' => 'Аналитический склад ума, внимание к деталям.'],
                'job_category_id' => 1,
                'region_id' => 1,
                'city' => 'Beograd',
                'positions_count' => 2,
                'hourly_rate_min' => 400,
                'hourly_rate_max' => 500,
                'working_hours_per_week' => 20,
                'shift_type' => 'flexible',
                'ad_type' => 'part_time',
                'employment_status_required' => 'student',
                'is_featured' => false,
                'status' => 'active',
                'published_at' => now()->subDays(1),
                'expires_at' => now()->addDays(25),
            ],
            [
                'company_id' => $companies[1]->id,
                'created_by' => 3,
                'title' => ['sr' => 'Barista', 'en' => 'Barista', 'ru' => 'Бариста'],
                'slug' => 'barista-novi-sad',
                'description' => ['sr' => 'CafeX traži baristu za naš novi lokal u centru Novog Sada. Obezbeđujemo kompletnu obuku za pripremu kafe.', 'en' => 'CafeX is looking for a barista for our new location in Novi Sad city center.', 'ru' => 'CafeX ищет баристу для нашего нового кафе.'],
                'requirements' => ['sr' => 'Komunikativnost, želja za učenjem. Iskustvo nije neophodno.', 'en' => 'Good communication, eagerness to learn. Experience not required.', 'ru' => 'Коммуникабельность, желание учиться.'],
                'job_category_id' => 2,
                'region_id' => 2,
                'city' => 'Novi Sad',
                'positions_count' => 3,
                'hourly_rate_min' => 320,
                'hourly_rate_max' => 400,
                'working_hours_per_week' => 20,
                'shift_type' => 'morning',
                'ad_type' => 'part_time',
                'employment_status_required' => 'both',
                'is_featured' => true,
                'status' => 'active',
                'published_at' => now()->subHours(6),
                'expires_at' => now()->addDays(18),
            ],
            [
                'company_id' => $companies[2]->id,
                'created_by' => 4,
                'title' => ['sr' => 'Promoter/ka', 'en' => 'Promoter', 'ru' => 'Промоутер'],
                'slug' => 'promoter-beograd',
                'description' => ['sr' => 'Tražimo promotere za vikend akcije u tržnim centrima u Beogradu. Dinamičan posao, mogućnost dodatne zarade.', 'en' => 'Looking for promoters for weekend events in Belgrade shopping centers.', 'ru' => 'Ищем промоутеров для акций в торговых центрах.'],
                'requirements' => ['sr' => 'Komunikativnost, reprezentativan izgled, pozitivna energija. Poželjno iskustvo u prodaji.', 'en' => 'Good communication, representative appearance, positive energy.', 'ru' => 'Коммуникабельность, представительный вид.'],
                'job_category_id' => 10,
                'region_id' => 1,
                'city' => 'Beograd',
                'positions_count' => 10,
                'hourly_rate_min' => 400,
                'hourly_rate_max' => 550,
                'working_hours_per_week' => 16,
                'shift_type' => 'flexible',
                'ad_type' => 'seasonal',
                'employment_status_required' => 'both',
                'is_featured' => true,
                'status' => 'active',
                'published_at' => now()->subDays(4),
                'expires_at' => now()->addDays(10),
            ],
            [
                'company_id' => $companies[3]->id,
                'created_by' => 5,
                'title' => ['sr' => 'Kurir na biciklu', 'en' => 'Bicycle Courier', 'ru' => 'Курьер на велосипеде'],
                'slug' => 'kurir-bicikl-beograd',
                'description' => ['sr' => 'LogiSerb traži kurire za dostavu paketa biciklom u centru Beograda. Idealno za studente koji vole da budu aktivni.', 'en' => 'LogiSerb is looking for bicycle couriers for package delivery in central Belgrade.', 'ru' => 'LogiSerb ищет курьеров на велосипеде.'],
                'requirements' => ['sr' => 'Sopstveni bicikl, dobra fizička kondicija, poznavanje grada.', 'en' => 'Own bicycle, good physical condition, city knowledge.', 'ru' => 'Собственный велосипед, хорошая физическая форма.'],
                'job_category_id' => 4,
                'region_id' => 1,
                'city' => 'Beograd',
                'positions_count' => 5,
                'hourly_rate_min' => 400,
                'hourly_rate_max' => 600,
                'working_hours_per_week' => 25,
                'shift_type' => 'flexible',
                'ad_type' => 'part_time',
                'employment_status_required' => 'both',
                'is_featured' => false,
                'status' => 'active',
                'published_at' => now()->subDays(2),
                'expires_at' => now()->addDays(15),
            ],
        ];

        foreach ($jobs as $jobData) {
            JobListing::create($jobData);
        }

        // Blog categories
        $blogCats = [
            BlogCategory::create(['name' => ['sr' => 'Karijera', 'en' => 'Career', 'ru' => 'Карьера'], 'slug' => 'karijera']),
            BlogCategory::create(['name' => ['sr' => 'Saveti', 'en' => 'Tips', 'ru' => 'Советы'], 'slug' => 'saveti']),
        ];

        // Blog posts
        BlogPost::create([
            'title' => ['sr' => 'Kako napisati savršen CV za studente', 'en' => 'How to Write the Perfect Student CV', 'ru' => 'Как написать идеальное резюме для студентов'],
            'slug' => 'kako-napisati-savrsen-cv',
            'body' => ['sr' => 'Pisanje CV-a može biti izazov za studente koji nemaju mnogo radnog iskustva. U ovom članku delimo praktične savete kako da istaknete svoje veštine i obrazovanje.', 'en' => 'Writing a CV can be challenging for students with limited work experience. In this article, we share practical tips.', 'ru' => 'Написание резюме может быть сложной задачей для студентов.'],
            'excerpt' => ['sr' => 'Praktični saveti za pisanje CV-a koji će vas istaći među drugim kandidatima.', 'en' => 'Practical tips for writing a CV that will make you stand out.', 'ru' => 'Практические советы по написанию резюме.'],
            'blog_category_id' => $blogCats[0]->id,
            'author_id' => $admin->id,
            'is_published' => true,
            'published_at' => now()->subDays(7),
        ]);

        BlogPost::create([
            'title' => ['sr' => '5 grešaka na razgovoru za posao', 'en' => '5 Job Interview Mistakes', 'ru' => '5 ошибок на собеседовании'],
            'slug' => '5-gresaka-na-razgovoru',
            'body' => ['sr' => 'Razgovor za posao je vaša prilika da ostavite dobar utisak. Evo najčešćih grešaka koje studenti prave i kako ih izbeći.', 'en' => 'A job interview is your chance to make a good impression. Here are the most common mistakes students make.', 'ru' => 'Собеседование - ваш шанс произвести хорошее впечатление.'],
            'excerpt' => ['sr' => 'Izbegnite najčešće greške na razgovoru za posao.', 'en' => 'Avoid the most common job interview mistakes.', 'ru' => 'Избегайте самых распространённых ошибок на собеседовании.'],
            'blog_category_id' => $blogCats[1]->id,
            'author_id' => $admin->id,
            'is_published' => true,
            'published_at' => now()->subDays(3),
        ]);

        // CMS Pages
        Page::create([
            'title' => ['sr' => 'O nama', 'en' => 'About Us', 'ru' => 'О нас'],
            'slug' => 'o-nama',
            'body' => ['sr' => 'Gaudeamus je studentska zadruga osnovana sa ciljem da poveže studente sa kvalitetnim poslodavcima u Srbiji. Naša misija je da svakom studentu omogućimo pristup legalnom i kvalitetnom zaposlenju.', 'en' => 'Gaudeamus is a student cooperative founded to connect students with quality employers in Serbia.', 'ru' => 'Gaudeamus - студенческий кооператив, основанный для связи студентов с качественными работодателями.'],
            'is_published' => true,
        ]);

        Page::create([
            'title' => ['sr' => 'Za poslodavce', 'en' => 'For Employers', 'ru' => 'Для работодателей'],
            'slug' => 'za-poslodavce',
            'body' => ['sr' => 'Pronađite mlade, motivisane radnike za vaše poslovanje. Gaudeamus vam omogućava brz pristup bazi od hiljada studenata širom Srbije.', 'en' => 'Find young, motivated workers for your business. Gaudeamus gives you quick access to thousands of students across Serbia.', 'ru' => 'Найдите молодых, мотивированных работников для вашего бизнеса.'],
            'is_published' => true,
        ]);
    }
}
