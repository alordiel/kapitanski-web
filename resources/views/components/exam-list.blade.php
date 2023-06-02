<div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <div id="exam-app">
        <div v-if="!selectedExamType">
            <h3 class="text-center font-bold text-3xl mb-3">{{ __('Select exam type') }}</h3>
            <p class="text-center mb-7">{{__('You can click the info icon for more details on the types')}}</p>
            <div class="grid gird-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                <div class="border rounded border-gray-300 dark:border-indigo-600  py-5 px-7  relative  ">
                    <h5 class="text-center text-xl my-7 text-2xl uppercase font-bold">{{__('All questions')}}</h5>
                    <button class="absolute top-3 right-3">
                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512"
                             height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path>
                        </svg>
                    </button>
                    <div class="flex justify-center">
                        <x-secondary-button @click="examType = 'allQuestions'">{{__("Start")}}</x-secondary-button>
                    </div>
                </div>
                <div class="border rounded border-gray-300 dark:border-indigo-600 py-5 px-7 relative">
                    <h5 class="text-center text-xl my-7 text-2xl uppercase font-bold">{{__('Select category')}}</h5>
                    <button class="absolute top-3 right-3">
                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512"
                             height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path>
                        </svg>
                    </button>
                    <div class="flex justify-center">
                        <x-secondary-button @click="examType = 'byCategory'">{{__("Start")}}</x-secondary-button>
                    </div>
                </div>
                <div class="border rounded border-gray-300 dark:border-indigo-600  py-5 px-7  relative">
                    <h5 class="text-center text-xl my-7 text-2xl uppercase font-bold">{{__('Practice mistaken')}}</h5>
                    <button class="absolute top-3 right-3">
                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512"
                             height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path>
                        </svg>
                    </button>
                    <div class="flex justify-center">
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
