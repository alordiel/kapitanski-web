<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class Exam40BT extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = Storage::json('40BT.json');
        $this->command->comment("is empty: " . empty($questions));

        if(!empty($questions)) {
            foreach ($questions as $question) {
                $question_text = $question['questionText'];
            }
        }
    }
}
