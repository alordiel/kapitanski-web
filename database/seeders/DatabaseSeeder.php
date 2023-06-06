<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin Spasov',
                'email' => 'spasov@timelinedev.com',
                'password' => Hash::make('123!@#123'),
            ],
            [
                'name' => 'Student Spasov',
                'email' => 'student@timelinedev.com',
                'password' => Hash::make('123!@#123'),
            ],
            [
                'name' => 'Teacher Spasov',
                'email' => 'teacher@timelinedev.com',
                'password' => Hash::make('123!@#123'),
            ]
        ]);

        DB::table('posts')->insert([
            [
                'title' => 'Белла Дона',
                'slug' => 'bela-dona',
                'content' => "<h3><i>What is Lorem Ipsum?</i></h3><p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p><h3><i>Why do we use it?</i></h3><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>",
                'excerpt' => 'What is Lorem Ipsum?Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the...',
                'created_at' => '2023-05-04 21:43:07',
                'updated_at' => '2023-05-04 07:43:07'
            ], [
                'title' => 'Mandagroras',
                'slug' => 'mandragoras',
                'content' => "<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p><h2>Why do we use it?</h2><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>",
                'excerpt' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the...',
                'created_at' => '2023-05-09 21:43:07',
                'updated_at' => '2023-05-09 07:43:07'
            ],
            [
                'title' => 'Sanctus',
                'slug' => 'sanctus',
                'content' => "<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p><h2>Why do we use it?</h2><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>",
                'excerpt' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the...',
                'created_at' => '2023-06-01 21:43:07',
                'updated_at' => '2023-06-01 07:43:07'
            ]
        ]);

        DB::table('exams')->insert([
            ['name' => 'Captains course 40BT'],
            ['name' => 'Demo of Captains course 40BT'],
        ]);

        DB::table('question_categories')->insert([
            [
                'name' => 'Четене на карти',
                'slug' => 'mapping'
            ], [
                'name' => 'Части на кораба',
                'slug' => 'ship-parts'
            ], [
                'name' => 'Флагове',
                'slug' => 'flags'
            ], [
                'name' => 'Морски знаци',
                'slug' => 'sea-signs'
            ],
        ]);

        DB::table('questions')->insert([
            ['question' => 'Корабният магнитен компас служи за:',
                'correct_answer' => 3,
                'question_category_id' => 2,
                'exam_id' => 1,
                'type' => 'text',
            ],
            ['question' => 'Основен навигационен прибор на кораба /задължителен за всички кораби/ е:',
                'correct_answer' => 8,
                'question_category_id' => 1,
                'exam_id' => 1,
                'type' => 'text',
            ],
            ['question' => 'Поддържащата течност /компасната течност/ на картушката при корабния магнитен компас е:',
                'correct_answer' => 11,
                'question_category_id' => 1,
                'exam_id' => 1,
                'type' => 'text',
            ],
        ]);

        DB::table('answers')->insert([
            ['answer' => 'Определяне на проплавано разстояние.', 'question_id' => 1,],
            ['answer' => 'Определяне на дълбочината.', 'question_id' => 1,],
            ['answer' => 'Определяне курса на кораба и снемане на пеленги.', 'question_id' => 1,],
            ['answer' => 'Определяне скоростта на кораба.', 'question_id' => 1,],
            ['answer' => 'Секстанта.', 'question_id' => 2,],
            ['answer' => 'Радиолокационната станция.', 'question_id' => 2,],
            ['answer' => 'Лот и ехолот.', 'question_id' => 2,],
            ['answer' => 'Магнитен компас.', 'question_id' => 2,],
            ['answer' => 'Дестилирана вода.', 'question_id' => 3,],
            ['answer' => 'Воден разтвор на етилов спирт.', 'question_id' => 3,],
            ['answer' => 'Машинно масло.', 'question_id' => 3,],
            ['answer' => 'Дизелово гориво.', 'question_id' => 3,],
        ]);

        $this->call([
            RoleAndPermissionSeeder::class,
        ]);
    }
}
