<x-app-layout>
    <x-slot name="header">
        <x-subheader title="{{$exam->name}}" icon="all" button-text="All exams" url="{{route('exam.admin.manage')}}"/>
    </x-slot>

    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>

    <div id="app">
        @{{ message }}
        <div v-for="(question,key) in questions" :key="key" class="mb-3">
            <div class="flex flex-wrap justify-between mb-3">
                <p class="w-1/3">
                    <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">@{{ key + 1 }}. Question
                        body<br>
                        <x-text-input type="text" v-model="question.body"/>
                    </label>
                </p>
                <p class="w-1/3">
                    <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">
                        Question type<br>
                        <input type="radio" :name="'question-type-' + key" v-model="question.type" value="text"> Text
                        <br>
                        <input type="radio" :name="'question-type-' + key" v-model="question.type" value="image"> Image
                    </label>
                </p>
                <p class="w-1/3">
                    <label :for="'cat-' + key" class="block font-medium text-sm text-gray-700 dark:text-gray-300">
                        Question category <br>
                        <select v-model="question.category" :id="'cat-' + key"
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
                <p class="w-1/2">
                    <x-text-input type="text" placeholder="answer" class="w-full" v-model="question.asnwerA"/>
                </p>
                <p class="w-1/2">
                    <x-text-input type="text" placeholder="answer" class="w-full" v-model="question.asnwerB"/>
                </p>
                <p class="w-1/2">
                    <x-text-input type="text" placeholder="answer" class="w-full" v-model="question.asnwerC"/>
                </p>
                <p class="w-1/2">
                    <x-text-input type="text" placeholder="answer" class="w-full" v-model="question.asnwerD"/>
                </p>
            </div>
            <div v-else class="flex justify-between flex-wrap mb-3">
                <p class="w-1/2">
                    <x-text-input type="file" class="w-full" v-model="question.asnwerA"/>
                </p>
                <p class="w-1/2">
                    <x-text-input type="file" class="w-full" v-model="question.asnwerB"/>
                </p>
                <p class="w-1/2">
                    <x-text-input type="file" class="w-full" v-model="question.asnwerC"/>
                </p>
                <p class="w-1/2">
                    <x-text-input type="file" class="w-full" v-model="question.asnwerD"/>
                </p>
            </div>
            <hr>
        </div>
        <x-primary-button type="button" @click="addQuestion">Add question</x-primary-button>
    </div>

    <script>
        const {createApp} = Vue

        createApp({
            data() {
                return {
                    questions: [
                        {
                            id: '',
                            body: '',
                            type: '',
                            category: '',
                            answerA: '',
                            answerB: '',
                            answerC: '',
                            answerD: '',
                            correctAnswer: ''
                        }
                    ],
                }
            },
            methods: {
                addQuestion() {
                    this.questions.push({
                        question: '',
                        answerA: '',
                        answerB: '',
                        answerC: '',
                        answerD: '',
                        correctAnswer: ''
                    })
                },
            }
        }).mount('#app')
    </script>
</x-app-layout>
