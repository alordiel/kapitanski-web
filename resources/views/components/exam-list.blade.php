<div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
    {{-- JS translations --}}
    @php
        $examTitles = [
            'all' => __('All questions'),
            'category' => __('Select a category'),
            'mistaken' => __('Practice mistaken')
        ];
        $examDescription = [
          'all' => __('Random number of questions will be selected from all the 600 questions. The exam will be made in such a way that it will get all the questions that have never been displayed before. The exam algorithm is keeping track of what questions have being selected and it will go through all the possible questions before starting to repeat them.'),
          'category' => __('You will be able to select a specific category of questions. This will make it easier for you to remember the questions. We recommend to start with this type of test as it is proven to have a better memory effect.'),
          'mistaken' => __('Starting with the other two test types you will (eventually) make some mistakes. This exam type is created to work with this particular mistaken questions, so repeating them you will get eventually better. Learning from your mistakes is inevitable ;)'),
        ];
    @endphp
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <div id="exam-app">
        <div v-if="!selectedExamType">
            <h3 class="text-center font-bold text-3xl mb-3">{{ __('Select exam type') }}</h3>
            <p class="text-center mb-7">{{__('You can click the info icon for more details on the types')}}</p>
            <div class="grid gird-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                <div class="border rounded border-gray-300 dark:border-indigo-600  py-5 px-7  relative  ">
                    <h5 class="text-center text-xl my-7 text-2xl uppercase font-bold">
                        {{ $examTitles['all'] }}
                    </h5>
                    <button class="absolute top-3 right-3" @click="openInfo('all')">
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
                    <h5 class="text-center text-xl my-7 text-2xl uppercase font-bold">
                        {{ $examTitles['category'] }}
                    </h5>
                    <button class="absolute top-3 right-3" @click="openInfo('category')">
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
                    <h5 class="text-center text-xl my-7 text-2xl uppercase font-bold">
                        {{ $examTitles['mistaken'] }}
                    </h5>
                    <button class="absolute top-3 right-3" @click="openInfo('mistaken')">
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

        {{-- Info Modal --}}
        <div
            class="fixed bg-gray-300/75 dark:bg-slate-800/75 w-screen h-screen top-0 left-0 flex justify-center items-center"
            v-show="showInfoModal"
        >
            <div
                class="w-60 lg:w-1/4 xl:w-1/5 bg-gray-300 py-7 px-5 dark:bg-slate-800 border-gray-300 dark:border-indigo-600 rounded border-2">
                <h3 class="text-xl font-bold text-center">@{{infoModal.title}}</h3>
                <div class="mb-4">
                    @{{infoModal.body}}
                </div>
                <div class="flex justify-center">
                    <button
                        @click="showInfoModal = false"
                        class="border border-gray-300 dark:border-indigo-600 rounded py-2 px-5"
                    >
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        const {createApp} = Vue;

        createApp({
            data() {
                return {
                    showResults: false,
                    examType: '',
                    showInfoModal: false,
                    infoModal: {
                        title: '',
                        body: '',
                    }
                }
            },
            computed: {
                selectedExamType() {
                    return this.examType !== '';
                },
            },
            methods: {
                openInfo(type) {
                    const titles = {
                        all: '{{$examTitles['all']}}',
                        category: '{{$examTitles['category']}}',
                        mistaken: '{{$examTitles['mistaken']}}',
                    };
                    const descriptions = {
                        all: '{{$examDescription['all']}}',
                        category: '{{$examDescription['category']}}',
                        mistaken: '{{$examDescription['mistaken']}}',
                    };
                    this.infoModal = {
                        body: descriptions[type],
                        title: titles[type],
                    }
                    this.showInfoModal = true;
                }
            }
        }).mount('#exam-app')
    </script>

</div>
