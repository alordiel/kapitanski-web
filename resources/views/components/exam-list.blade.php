@php
    use \App\Models\QuestionCategory;
    $categories = QuestionCategory::all();
@endphp

<div class="p-4 sm:p-8 lg:p-10 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
    {{-- JS translations --}}
    @php
        $examTitles = [
            'practice' => __('Practice'),
            'real'     => __('Real exam'),
            'mistaken' => __('Mistakes')
        ];
    @endphp
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <div id="exam-app" class="mb-7">
        <div v-if="exam.length === 0">
            <h3 class="text-center font-bold text-3xl mb-3">{{ __('Select exam type') }}</h3>
            <p class="text-center mb-7">{{__('You can click the info icon for more details on the types')}}</p>
            <div class="grid gird-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">

                @foreach($examTitles as $examKey => $examTitle)
                    <div class="border rounded border-gray-300 dark:border-indigo-600  py-5 px-7  relative  ">
                        <h5 class="text-center text-xl my-7 text-2xl uppercase font-bold">
                            {{ $examTitle }}
                        </h5>
                        <div class="flex justify-center">
                            <x-secondary-button @click="openExamConfig('{{ $examKey }}')">
                                {{__("Start")}}
                            </x-secondary-button>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>

        {{-- Exam with questions panel --}}
        <div v-if="!showResults && exam.length > 0">
            {{-- The indicator of the questions --}}
            <div class="flex flex-wrap">
                <div
                    v-for="(eachQuestion,questionIndex) in exam"
                    :key="'questions-tab-' + questionIndex"
                    class="w-10 h-10 mx-4 bg-gray-500 dark:bg-green-300 cursor-pointer"
                    :class="{'dark:border-pink-900 border-blue-600 border-2':questionIndex === questions.currentQuestion}"
                    :title="eachQuestion.question"
                    @click="questions.currentQuestion = questionIndex"
                ></div>
            </div>

            {{-- The questions --}}
            <div>
                <div class="font-bold text-xl mb-3">@{{ exam[questions.currentQuestion].question }}</div>
                <div class="grid grid-cols-2">

                    <div
                        v-for="(answer, answerIndex) in exam[questions.currentQuestion].answers"
                        class="py-3 px-4 m-3 border border-gray-300 dark:border-indigo-600 cursor-pointer"
                        :class="{'bg-gray-400': answer.id === exam[questions.currentQuestion].userAnswer}"
                        :key="'answer'+answerIndex"
                        @click="selectAnswer(answer.id)"
                    >
                        @{{ answer.answer }}
                    </div>
                </div>
            </div>
            <div
                class="grid grid-cols-2"
                v-show="exam[questions.currentQuestion].userAnswer !== 0"
            >
                <button
                    type="button"
                    class=""
                    v-show="questions.currentQuestion !== 0"
                    @click="questions.currentQuestion--"
                >
                    < {{__('Previous')}}
                </button>
                <button
                    type="button"
                    class=""
                    v-show="questions.currentQuestion + 1 !== exam.length"
                    @click="questions.currentQuestion++"
                >
                    {{__('Next')}} >
                </button>
                <button
                    type="button"
                    class=""
                    v-show="questions.allAnswered"
                    @click="submitExam"
                >
                    {{__('Finish')}}
                </button>
            </div>
        </div>

        {{-- Results --}}
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

                    <div class="block mt-4">
                        <label for="question-categories"
                               class="block font-medium text-sm text-gray-700 dark:text-gray-300">
                            {{__('Select category')}} <br>
                            <select v-model="examConfiguration.categoryID" id="question-categories"
                                    class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="-1">{{__('All categories')}}</option>
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

                    <div class="block mt-4"
                         v-show="examConfiguration.type === 'practice'">
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

                <div class="text-center mb-5" v-show="modals.config.error !== ''">
                    <p class="w-full border border-red-500 text-red-600">@{{ modals.config.error }}</p>
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

    <div>
        <p class="mb-3">{{__("There are 3 types of exams that you can choose from. Each of them have their specific purposes and idea.")}}</p>
        <p class="mb-3">
            {!! __("The <strong>'Practice'</strong> tests gives you the option to select your own number of questions per test, as well if you want to practice particular category of questions. This type of tests will give you always the lest seen questions so it is a good starting point for learning the questions. Random number of questions will be selected from all the 600 questions. The exam will be made in such a way that it will get all the questions that have never been displayed before. The exam algorithm is keeping track of what questions have being selected and it will go through all the possible questions before starting to repeat them.") !!}
        </p>
        <p class="mb-3">
            {!! __("The <strong>'Real exam'</strong> is following the requirements from the Ministry of Transport and Communication. With this test you can check if you are ready for the actual exam. The test is with time limit of 30min and you will have 60 questions from all the categories. You need to make less then 6 mistakes to pass the exam.") !!}
        </p>
        <p class="mb-3">
            {!! __("The <strong>'Mistakes'</strong> test will help you improve the mistakes you have done previously. This exam type is created to work with this particular mistaken questions, so repeating them you will get eventually better. Learning from your mistakes is inevitable ;)") !!}
        </p>
        <p><em>{{__("Good luck!")}}</em></p>
    </div>

    <script>
        const {createApp, nextTick} = Vue;
        const questionCategories = <?php echo json_encode($categories, JSON_NUMERIC_CHECK); ?>;

        createApp({
            data() {
                return {
                    examTitles: {
                        all: '{{$examTitles['practice']}}',
                        mistaken: '{{$examTitles['mistaken']}}',
                        real: '{{$examTitles['real']}}',
                    },
                    questionCategories: questionCategories,
                    showResults: false,
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
                    exam: [],
                    questions: {
                        currentQuestion: 0,
                        allAnswered: false,
                        numberOfAnswered: 0,
                        totalQuestions: 0,
                    },
                    timer: {
                        active: false,
                        duration: 40 * 60,
                    },
                    examConfiguration: {
                        examTitle: '',
                        type: '',
                        numberOfQuestions: 20,
                        showCorrectAnswer: true,
                        categoryID: 0,
                        showExplanation: false,
                    },
                    loading: {
                        startExam: false,
                        directStart: false,
                        finalResult: false,
                    }
                }
            },
            computed: {},
            methods: {
                openExamConfig(type) {

                    this.examConfiguration.type = type;
                    this.examConfiguration.examTitle = this.examTitles[type];

                    if(type==='practice') {
                        this.modals.config.visible = true;
                        this.modals.config.error = '';
                    } else {
                        this.startExam();
                    }
                },

                startExam() {

                    if (this.examConfiguration.type === 'practice' && this.examConfiguration.categoryID === '') {
                        this.modals.config.error = '{{__('Please select a category.')}}'
                        return;
                    }

                    const vm = this;
                    const token = '{{ auth()->user()->createToken('lol',['get-exam'])->plainTextToken }}';
                    this.loading.startExam = true;
                    this.modals.config.error = '';

                    axios.defaults.withCredentials = true;

                    axios({
                        url: '/api/v1/get-questions',
                        method: 'post',
                        data: this.examConfiguration,
                        headers: {
                            Authorization: `Bearer ${token}`,
                            Accept: 'application/json',
                        }
                    })
                        .then(async res => {
                            console.log(res.data.exam)
                            if (res.data.status === 'failed') {
                                vm.modals.config.error = res.data.message;
                            } else {
                                if (res.data.exam.length > 0) {
                                    // add the user's answer property
                                    res.data.exam.forEach(entry => {
                                        entry.userAnswer = 0;
                                    })
                                    vm.questions.totalQuestions = res.data.exam.length;
                                    vm.exam = res.data.exam;
                                    await nextTick();
                                }
                                vm.modals.config.visible = false;
                            }
                            vm.loading.startExam = false;
                        })
                        .catch(error => {
                            console.log(error)
                            if (error.response !== undefined && error.response.data !== undefined && error.response.data.message !== undefined) {
                                vm.modals.config.error = error.response.data.message;
                            } else {
                                vm.modals.config.error = error.message;
                            }
                            vm.loading.startExam = false;
                        });
                },

                selectAnswer(answerID) {
                    this.exam[this.questions.currentQuestion].userAnswer = answerID;
                    this.questions.numberOfAnswered++
                    this.questions.allAnswered = (this.questions.numberOfAnswered === this.questions.totalQuestions)
                },

                finishExam() {

                }
            }
        }).mount('#exam-app')
    </script>

</div>
