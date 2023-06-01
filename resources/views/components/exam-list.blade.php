<div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <div id="exam-app">
        <div v-if="!selectedExamType">
            <h3 class="text-center font-bold text-3xl mb-3">{{ __('Select exam type') }}</h3>
            <p class="text-center mb-7">{{__('You can click the info icon for more details on the types')}}</p>
            <div class="grid gird-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                <div class="border rounded border-gray-300 dark:border-indigo-600">
                    <h5 class="text-center text-xl">{{__('All questions')}}</h5>
                    <div class="flex justify-between">
                        <button>info</button>
                        <x-secondary-button @click="examType = 'allQuestions'">{{__("Start")}}</x-secondary-button>
                    </div>
                </div>
                <div class="border rounded border-gray-300 dark:border-indigo-600">
                    <h5 class="text-center text-xl">{{__('Select category')}}</h5>
                    <div class="flex justify-between">
                        <button>info</button>
                        <x-secondary-button @click="examType = 'byCategory'">{{__("Start")}}</x-secondary-button>
                    </div>
                </div>
                <div class="border rounded border-gray-300 dark:border-indigo-600">
                    <h5 class="text-center text-xl">{{__('Practice mistaken')}}</h5>
                    <div class="flex justify-between">
                        <button>info</button>
                        <x-secondary-button @click="examType = 'mistakes'">{{__("Start")}}</x-secondary-button>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="examType !== '' && !showResults">
            You have selected @{{ examType }}
        </div>
        <div v-if="showResults">
            Results
        </div>
    </div>
    <script>
        const {createApp} = Vue;

        createApp({
            data() {
                return {
                    showResults: false,
                    examType: '',
                }
            },
            computed: {
                selectedExamType() {
                    return this.examType !== '';
                },
            },
            methods: {}
        }).mount('#exam-app')
    </script>
</div>
