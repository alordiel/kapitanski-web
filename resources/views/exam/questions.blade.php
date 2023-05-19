@php
use \App\Models\QuestionCategory;
use \App\Models\Question;
use \App\Models\Exam;
use Illuminate\Support\Facades\DB;
$categories = QuestionCategory::all();
@endphp
<x-app-layout>
    <x-slot name="header">
        <x-subheader title="{{$exam->name}} | Manage questions" icon="all" button-text="All exams"
                     url="{{route('exam.admin.manage')}}"/>
    </x-slot>

    @php
    $examm = Exam::find($exam->id)->questions;
    @endphp
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script> const questionCategories = <?php echo json_encode($categories, JSON_NUMERIC_CHECK) ?></script>

    <div id="app">
        <div v-for="(question,questionIndex) in questions" :key="questionIndex" class="mb-3">
            <div class="flex flex-wrap justify-between mb-3">
                <p class="w-1/3">
                    <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">
                        @{{ questionIndex + 1 }}. Question body<br>
                        <x-text-input type="text" v-model="question.body"/>
                    </label>
                </p>
                <p class="w-1/3">
                    <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">
                        Question type<br>
                        <input type="radio" :name="'question-type-' + questionIndex" v-model="question.type"
                               value="text"> Text
                        <br>
                        <input type="radio" :name="'question-type-' + questionIndex" v-model="question.type"
                               value="image"> Image
                    </label>
                </p>
                <p class="w-1/3">
                    <label :for="'cat-' + questionIndex"
                           class="block font-medium text-sm text-gray-700 dark:text-gray-300">
                        Question category <br>
                        <select v-model="question.category" :id="'cat-' + questionIndex"
                                class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            <option
                                v-for="(category, key) in categories"
                                :value="category.id"
                                :selected="category.id === questions[questionIndex].category">
                                @{{category.name}}
                            </option>
                        </select>
                    </label>
                </p>
            </div>


            <div v-if="question.type !== 'image'" class="flex justify-between flex-wrap mb-3">
                <p class="w-1/2" v-for="textIndex in [0,1,2,3]" :key="'textAnswer-'+textIndex">
                    <x-text-input
                        type="text"
                        placeholder="answer"
                        class="w-full"
                        v-model="question.textAnswers[textIndex].content"
                    />
                    <br>
                    <label>
                        <input
                            type="radio"
                            :checked="(question.textAnswers[textIndex].isCorrect === true)"
                            :name="'correctAnswer' + textIndex"
                            @change="changeOfCorrect(questionIndex, textIndex)"
                        /> is the correct answer
                    </label>
                </p>
            </div>

            <div v-else class="flex justify-between flex-wrap mb-3">
                <p class="w-1/2" v-for="imageIndex in [0,1,2,3]" :key="'imageAnswer-'+imageIndex">
                    <x-text-input
                        type="file"
                        accept="image/*"
                        @change="uploadImage($event, questionIndex, imageIndex)"
                        class="w-full"
                    />
                    <br>
                    <label>
                        <input
                            type="radio"
                            :checked="(question.imageAnswers[imageIndex].isCorrect === true)"
                            @change="changeOfCorrect(questionIndex, imageIndex)"
                            name="correctAnswer"
                        /> is the correct answer
                    </label>
                    <br>
                    <img
                        v-if="question.imageAnswers[imageIndex].content !== ''"
                        :src="question.imageAnswers[imageIndex].content"
                        alt="exam"
                        style="height: 100px"
                    >
                </p>
            </div>
            <hr>
        </div>
        <x-secondary-button type="button" @click="addQuestion">Add question</x-secondary-button>
        <x-primary-button type="button" @click="saveQuestions" class="ml-3">Save</x-primary-button>
        <input type="hidden" value="{{$exam->id}}" id="exam-id">
    </div>

    <script>
        const {createApp} = Vue;
        const questionStructure = {
            id: '',
            body: '',
            type: 'text',
            category: '',
            textAnswers: [
                {id: 0, content: '', isCorrect: false},
                {id: 0, content: '', isCorrect: false},
                {id: 0, content: '', isCorrect: false},
                {id: 0, content: '', isCorrect: false}
            ],
            imageAnswers: [
                {id: 0, content: '', file: '', isCorrect: false},
                {id: 0, content: '', file: '', isCorrect: false},
                {id: 0, content: '', file: '', isCorrect: false},
                {id: 0, content: '', file: '', isCorrect: false},
              ],
        };

        createApp({
            data() {
                return {
                    questions: [{}],
                    categories: [],
                }
            },
            created() {
                this.questions[0] = Object.assign({}, questionStructure)
                this.categories = questionCategories;
            },
            methods: {
                addQuestion() {
                    this.questions.push(Object.assign({}, questionStructure));
                },

                changeOfCorrect(questionIndex, answerIndex) {
                    const answerType = this.questions[questionIndex].type === 'text' ? 'textAnswers' : 'imageAnswers';
                    if (this.questions[questionIndex][answerType][answerIndex].isCorrect === true) {
                        this.questions[questionIndex][answerType][answerIndex].isCorrect = false
                    } else {
                        // set all other answers to false
                        this.questions[questionIndex][answerType].forEach(e => {
                            e.isCorrect =  false
                        })

                         this.questions[questionIndex][answerType][answerIndex].isCorrect = true;
                    }
                },

                uploadImage($event, questionIndex, answerIndex) {
                    const target = $event.target;
                    if (target && target.files) {
                        const vm = this;
                        this.questions[questionIndex].imageAnswers[answerIndex].file = target.files[0];
                        axios.post('/api/v1/file-upload', {
                                type: 'exams',
                                image: target.files[0]
                            },
                            {
                                headers: {
                                    'Content-Type': 'multipart/form-data'
                                }
                            })
                            .then(res => {
                                if (res.data.status === 1) {
                                    vm.questions[questionIndex].imageAnswers[answerIndex].id = res.data.id;
                                    vm.questions[questionIndex].imageAnswers[answerIndex].content = location.origin + '/' + res.data.url;
                                } else {
                                    alert(res.data.message);
                                }
                            })
                            .catch(error => {
                                alert(error)
                                console.log(error)
                            });
                    }
                },

                saveQuestions() {
                    const vm = this;
                    // TODO - validate the answers
                    axios.post('/api/v1/save-questions', {
                        examId: document.getElementById('exam-id').value,
                        questions: this.questions
                    })
                        .then(res => {
                            alert(res.data.message)
                            vm.questions = res.data.questions;
                        })
                        .catch(error => {
                            console.log(error)
                            alert(error)
                        })
                },

            }
        }).mount('#app')
    </script>
</x-app-layout>
