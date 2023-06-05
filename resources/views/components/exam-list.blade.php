@php
    use \App\Models\QuestionCategory;
    $categories = QuestionCategory::all();
@endphp
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
                        <x-secondary-button @click="openExamConfig('all')">{{__("Start")}}</x-secondary-button>
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
                        <x-secondary-button @click="openExamConfig('category')">{{__("Start")}}</x-secondary-button>
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
                        <x-secondary-button @click="openExamConfig('mistaken')">
                            {{__("Start")}}

                        </x-secondary-button>
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
            v-show="modals.info.visible"
        >
            <div
                class="w-60 lg:w-1/4 xl:w-1/5 bg-white py-7 px-5 dark:bg-slate-800 border-gray-300 dark:border-indigo-600 rounded border-2">
                <h3 class="text-xl font-bold text-center">@{{modals.info.title}}</h3>
                <div class="mb-4">
                    @{{modals.info.body}}
                </div>
                <div class="flex justify-center">
                    <button
                        @click="modals.info.visible = false"
                        class="border border-gray-300 dark:border-indigo-600 rounded py-2 px-5"
                    >
                        {{__('Close')}}
                    </button>
                </div>
            </div>
        </div>

        {{-- Exam configuration modal --}}
        <div
            class="fixed bg-gray-300/75 dark:bg-slate-800/75 w-screen h-screen top-0 left-0 flex justify-center items-center"
            v-show="modals.config.visible"
        >
            <div
                class="w-60 lg:w-1/4 xl:w-1/5 bg-white py-7 px-5 dark:bg-slate-800 border-gray-300 dark:border-indigo-600 rounded border-2">
                <h3 class="text-xl font-bold text-center">@{{examConfiguration.examTitle}}</h3>
                <div class="mb-4">

                    <div class="block mt-4" v-show="examConfiguration.type === 'category'">
                        <label for="question-categories"
                               class="block font-medium text-sm text-gray-700 dark:text-gray-300">
                            {{__('Question category')}} <br>
                            <select v-model="examConfiguration.selectedCategory" id="question-categories"
                                    class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option
                                    v-for="(category, key) in questionCategories"
                                    :key="'qo-'+key"
                                    :value="category.id"
                                >
                                    @{{category.name}}
                                </option>
                            </select>
                        </label>
                    </div>

                    <div class="block mt-4" v-show="examConfiguration.type === 'all'">
                        <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">
                            {{__('Test type')}}<br>
                            <label for="time-test">
                                <input type="radio" name="test-type" v-model="examConfiguration.variation"
                                       value="time" id="time-test">
                                {{__('Time test')}}
                            </label>
                            <label for="all-test" class="inline-block ml-4">
                                <input type="radio" name="test-type" v-model="examConfiguration.variation"
                                       value="all" id="all-test">
                                {{__('All questions')}}
                            </label>
                            <label for="custom-test" class="inline-block ml-4">
                                <input type="radio" name="test-type" v-model="examConfiguration.variation"
                                       value="custom" id="custom-test">
                                {{__('Custom')}}
                            </label>
                        </label>
                    </div>

                    <div class="block mt-4" v-show="examConfiguration.variation === 'custom'">
                        <label for="numberOfQuestions"
                               class="block font-medium text-sm text-gray-700 dark:text-gray-300">
                            {{__('Selected number of questions:')}}
                            <span id="display-selected">@{{ examConfiguration.numberOfQuestions }}</span>
                        </label>
                        <input
                            class="w-full"
                            type="range"
                            id="numberOfQuestions"
                            name="numberOfQuestions"
                            v-model="examConfiguration.numberOfQuestions"
                            min="10"
                            max="600"
                            value="20"
                        >
                    </div>

                    <div class="block mt-4">
                        <label for="show-correct" class="inline-flex items-center">
                            <input id="show-correct" type="checkbox"
                                   class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                                   name="show-correct"
                                   v-model="examConfiguration.showCorrectAnswer"
                            >
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Show correct answer after submitting answer') }}
                            </span>
                        </label>
                    </div>

                </div>

                <div class="flex justify-center">
                    <button
                        :disabled="loading.startExam"
                        @click="modals.config.visible = false"
                        class="border border-gray-300 dark:border-indigo-600 rounded py-2 px-5 disabled:opacity-25"
                    >
                        {{__('Close')}}
                    </button>
                    <button
                        @click="startExam()"
                        :disabled="loading.startExam"
                        class="ml-4 border border-sky-600 dark:border-indigo-600 bg-sky-700 text-white dark:bg-indigo-600 rounded py-2 px-5 disabled:opacity-25"
                    >
                        {{__('Start')}}
                        <svg v-show="loading.startExam" class="animate-spin inline-block ml-4" stroke="currentColor"
                             fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="1em" width="1em"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        const {createApp} = Vue;
        const questionCategories = <?php echo json_encode($categories, JSON_NUMERIC_CHECK); ?>;

        createApp({
            data() {
                return {
                    examTitles: {
                        all: '{{$examTitles['all']}}',
                        category: '{{$examTitles['category']}}',
                        mistaken: '{{$examTitles['mistaken']}}',
                    },
                    questionCategories: questionCategories,
                    showResults: false,
                    examType: '',
                    modals: {
                        info: {
                            title: '',
                            body: '',
                            visible: false,
                        },
                        config: {
                            error: '',
                            visible: false,
                        }
                    },
                    exam: {},
                    timer: {
                      active: false,
                      duration: 40 * 60,
                    },
                    examConfiguration: {
                        examTitle: '',
                        type: '',
                        variation: 'custom',
                        numberOfQuestions: 20,
                        showCorrectAnswer: true,
                        selectedCategory: '',
                        showExplanation: false,
                    },
                    loading: {
                        startExam: false,
                        directStart: false,
                        finalResult: false,
                    }
                }
            },
            computed: {
                selectedExamType() {
                    return this.examType !== '';
                },
            },
            methods: {
                openExamConfig(type) {
                    this.examConfiguration.type = type;
                    this.examConfiguration.examTitle = this.examTitles[type];
                    this.modals.config.visible = true;
                    this.modals.config.error = '';
                },
                openInfo(type) {
                    const descriptions = {
                        all: '{{$examDescription['all']}}',
                        category: '{{$examDescription['category']}}',
                        mistaken: '{{$examDescription['mistaken']}}',
                    };
                    this.modals.info.body = descriptions[type];
                    this.modals.info.title = this.examTitles[type];
                    this.modals.info.visible = true;
                },
                startExam() {
                    const vm = this;
                    this.loading.startExam = true;
                    this.modals.config.error = '';

                    axios.post('/api/v1/get-questions', {
                        examId: document.getElementById('exam-id').value,
                        config: this.examConfiguration,
                    })
                        .then(res => {
                            vm.exam = res.data.exam;
                            vm.loading.startExam = false;
                            vm.modals.config.visible = false;
                        })
                        .catch(error => {
                            vm.loading.startExam = false;
                            vm.modals.config.error = error;
                            console.log(error)
                            alert(error)
                        })
                },
            }
        }).mount('#exam-app')
    </script>

</div>
