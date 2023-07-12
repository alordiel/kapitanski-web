<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Question;
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

        if (!empty($questions)) {

            foreach ($questions as $question_entry) {

                if (empty($question_entry['questionText'])) {
                    $this->command->error('EMPTY: ' . $question_entry['questionText']);
                    continue;
                }

                $question = new Question();
                $question->exam_id = 1;
                $question->question = $question_entry['questionText'];
                $question->type = 'text';
                $question->question_category_id = 1;
                $question->save();

                $answers = $question_entry['answers'];
                foreach ($answers as $answer_entry) {
                    if (empty($question_entry['answers'])) {
                        $this->command->error('EMPTY Answer for: ' . $question_entry['questionText']);
                        continue;
                    }
                    $answer = new Answer([
                        'answer' => $answer_entry['answer']
                    ]);
                    $answer->save();
                    if ($answer_entry['isCorrect']) {
                        $question->correct_answer = $answer->id;
                        $question->save();
                    }
                    $question->answers()->save($answer);
                }
            }
        } else {
            $this->command->comment("There is no file with name 40BT.json in the /storage/app path");
        }
    }
}
