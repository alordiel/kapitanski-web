<x-app-layout>
    <x-slot name="header">
        <x-subheader title="{{$exam->name}} | Manage questions" icon="all" button-text="All exams" url="{{route('exam.admin.manage')}}"/>
    </x-slot>

    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

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
                            <option value="0"> - - -</option>
                            <option value="1">Морски знаци</option>
                            <option value="2">Четене на карта</option>
                            <option value="3">Навигация</option>
                            <option value="4">Части на кораба</option>
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
                        v-model="question.textAnswers[textIndex].text"
                    />
                    <br>
                    <label>
                        <input
                            :value="question.textAnswers[textIndex].id ? question.textAnswers[textIndex].id : textIndex"
                            type="radio"
                            v-model="question.correctAnswer"
                            :name="'correctAnswer' + textIndex"
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
                            :value="question.imageAnswers[imageIndex].id ? question.imageAnswers[imageIndex].id : imageIndex"
                            type="radio"
                            v-model="question.correctAnswer"
                            name="correctAnswer"
                        /> is the correct answer
                    </label>
                    <br>
                    <img
                        v-if="question.imageAnswers[imageIndex].url !== ''"
                        :src="question.imageAnswers[imageIndex].url"
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
            type: '',
            category: '',
            correctAnswer: '',
            textAnswers: [{id: 0, text: ''}, {id: 0, text: ''}, {id: 0, text: ''}, {id: 0, text: ''}],
            imageAnswers: [{id: 0, url: '', file: ''}, {id: 0, url: '', file: ''}, {id: 0, url: '', file: ''}, {
                id: 0,
                url: '',
                file: ''
            }],
        };

        createApp({
            data() {
                return {
                    questions: [{}],
                }
            },
            created() {
                this.questions[0] = Object.assign({}, questionStructure)
            },
            methods: {
                addQuestion() {
                    this.questions.push(Object.assign({}, questionStructure));
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
                                    vm.questions[questionIndex].imageAnswers[answerIndex].url = location.origin + '/' + res.data.url;
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
                    axios.post('/api/v1/save-questions', {
                        examId: document.getElementById('exam-id').value,
                        questions: this.questions
                    })
                        .then(res => {
                            alert(res.data.message)
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
