@php
    use App\Models\QuestionCategory;
    use Illuminate\Support\Facades\Auth;
    use App\Models\User;

    $user = Auth::user();
    $categories = QuestionCategory::all();
    $userObj = User::find($user->id);
    $mistakenQuestions = $userObj->wrongQuestions;
    $countOfMistaken = count($mistakenQuestions);
@endphp

<div class="p-4 sm:p-8 lg:p-10 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
    {{-- JS translations --}}
    @php
        $examTitles = [
            'practice' => __('Practice'),
            'real'     => __('Real exam'),
        ];
        // Show the Practice of mistakes only if we have more than 10
        if ($countOfMistaken > 10) {
            $examTitles['mistaken'] = __('Mistakes');
        }
    @endphp
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <div id="exam-app" class="mb-7">
        <div v-if="exam.length === 0">
            <h3 class="text-center font-bold text-3xl mb-3">{{ __('Select exam type') }}</h3>
            <div class="grid gird-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">

                @foreach($examTitles as $examKey => $examTitle)
                    <div class="border rounded border-gray-300 dark:border-indigo-600  py-5 px-7  relative  ">
                        <h5 class="text-center text-xl my-7 text-2xl uppercase font-bold">
                            {{ $examTitle }}
                        </h5>
                        <div class="flex justify-center">
                            <button
                                class="secondary-button"
                                @if($examKey === 'real')
                                    :disabled="loading.startReal"
                                @elseif($examKey === 'mistaken')
                                    :disabled="loading.startMistaken"
                                @endif
                                @click="openExamConfig('{{ $examKey }}')"
                            >
                                {{__("Start")}}
                                @if($examKey !== 'practice')
                                    <svg class="animate-spin inline-block ml-4"
                                         @if($examKey === 'real')
                                             v-show="loading.startReal"
                                         @elseif($examKey === 'mistaken')
                                             v-show="loading.startMistaken"
                                         @endif
                                         stroke="currentColor"
                                         fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="1em"
                                         width="1em"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z"></path>
                                    </svg>
                                @endif
                            </button>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>

        {{-- Exam with questions panel --}}
        <div v-if="!finalResult.visible && exam.length > 0">
            <div v-show="timer.active">
                <div :class="{'text-red-600':timer.left < 5 * 60}">@{{ timer.running }}</div>
            </div>
            {{-- Reset the exam link --}}
            <div class="relative w-100 h-5">
                <div class="absolute top-3 right-5">
                    <button @click="resetExam">{{__('Reset exam')}}</button>
                </div>
            </div>
            {{-- The indicator of the questions --}}
            <div class="flex flex-wrap">
                <div
                    v-for="(eachQuestion,questionIndex) in exam"
                    :key="'questions-tab-' + questionIndex"
                    class="w-10 h-10 mx-4 bg-gray-500 cursor-pointer"
                    :class="[
                            {'dark:border-pink-900 border-blue-600 border-2':questionIndex === questions.currentQuestion},
                            eachQuestion.userAnswer !== 0 ? 'dark:bg-green-300' : 'dark:bg-gray-300'
                        ]"
                    :title="eachQuestion.question"
                    @click="questions.currentQuestion = questionIndex"
                ></div>
            </div>

            {{-- The question text --}}
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

            {{-- Question's answers --}}
            <div
                class="flex justify-center flex-wrap"
            >
                <button
                    type="button"
                    class="secondary-button mx-3 w-32 text-center blcok"
                    v-show="questions.currentQuestion !== 0"
                    @click="questions.currentQuestion--"
                >
                    < {{__('Previous')}}
                </button>

                <button
                    type="button"
                    class="primary-button mx-5 w-32 text-center block"
                    v-show="questions.allAnswered || questions.currentQuestion+1 === exam.length"
                    @click="submitExam"
                    :disabled="loading.submitExam"
                >
                    {{__('Finish')}}
                    <svg v-show="loading.submitExam" class="animate-spin inline-block ml-4" stroke="currentColor"
                         fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="1em" width="1em"
                         xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z"></path>
                    </svg>
                </button>

                <button
                    type="button"
                    class="secondary-button mx-3 w-32 text-center block"
                    v-show="questions.currentQuestion + 1 !== exam.length"
                    @click="questions.currentQuestion++"
                >
                    {{__('Next')}} >
                </button>
            </div>
        </div>

        {{-- Results --}}
        <div v-if="finalResult.visible">
            <h3 class="text-2xl font-bold mb-3">{{__('Results')}}</h3>
            <p
                class="font-bold text-xl mb-3"
                :class="[finalResult.percentCorrect >= 90 ? 'text-green-500' : 'text-red-600']"
            >
                @{{ finalResult.message }}
            </p>
            <p class="my-5">
                <button class="secondary-button mr-4" @click="reDoExam">
                    {{__('Redo the exam')}}
                </button>
                <span class="px-4 inline-block">{{__('OR')}}</span>
                <button class="secondary-button" @click="resetExam(true)">
                    {{__('Start a new exam')}}
                </button>
            </p>

            <div v-if="finalResult.wrong > 0">
                <button class="underline" v-show="!finalResult.showWrongAnswers"
                        @click="finalResult.showWrongAnswers = true">
                    {{__('Show wrong answers')}}
                </button>
                <h4 v-show="finalResult.showWrongAnswers" class="text-xl font-bold">{{__('Wrong answers')}}</h4>
                <div v-show="finalResult.showWrongAnswers">
                    <div class="mb-5" v-for="(question, qIndex) in exam.filter(e=>e.userAnswer !== e.correct_answer)"
                         :key="'wrong-'+qIndex">
                        <p class="font-bold mb-3">@{{question.question}}</p>
                        <p class="text-green-600">
                            <strong>{{__('Correct')}}</strong>: @{{question.answers.find(e=>e.id ===
                            question.correct_answer).answer}}
                        </p>
                        <p class="text-red-600">
                            <strong>{{__('Wrong')}}</strong>: @{{question.answers.find(e=>e.id ===
                            question.userAnswer).answer}}
                        </p>
                    </div>
                </div>
            </div>

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
                         v-show="examConfiguration.categoryID === '-1'">
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
                        :disabled="loading.startReal"
                        @click="modals.config.visible = false"
                        class="border border-gray-300 dark:border-indigo-600 rounded py-2 px-5 disabled:opacity-25"
                    >
                        {{__('Close')}}
                    </button>
                    <button
                        @click="startExam()"
                        :disabled="loading.startPractice"
                        class="ml-4 border border-sky-600 dark:border-indigo-600 bg-sky-700 text-white dark:bg-indigo-600 rounded py-2 px-5 disabled:opacity-25"
                    >
                        {{__('Start')}}
                        <svg v-show="loading.startPractice" class="animate-spin inline-block ml-4" stroke="currentColor"
                             fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="1em" width="1em"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Description of the exam types --}}
        <div class="mt-7" v-show="exam.length === 0">
            <p class="mb-3">
                {!! __("The <strong>'Practice'</strong> tests gives you the option to select your own number of questions per test, as well if you want to practice particular category of questions. This type of tests will give you always the lest seen questions so it is a good starting point for learning the questions. Random number of questions will be selected from all the 600 questions. The exam will be made in such a way that it will get all the questions that have never been displayed before. The exam algorithm is keeping track of what questions have being selected and it will go through all the possible questions before starting to repeat them.") !!}
            </p>
            <p class="mb-3">
                {!! __("The <strong>'Real exam'</strong> is following the requirements from the Ministry of Transport and Communication. With this test you can check if you are ready for the actual exam. The test is with time limit of 30min and you will have 60 questions from all the categories. You need to make less then 6 mistakes to pass the exam.") !!}
            </p>
            @if($countOfMistaken > 10)
                <p class="mb-3">
                    {!! __("The <strong>'Mistakes'</strong> test will help you improve the mistakes you have done previously. This exam type is created to work with this particular mistaken questions, so repeating them you will get eventually better. Learning from your mistakes is inevitable ;)") !!}
                </p>
            @endif
            <p><em>{{__("Good luck!")}}</em></p>
        </div>
    </div>


    <script>
        const {createApp, nextTick} = Vue;
        const questionCategories = <?php echo json_encode($categories, JSON_NUMERIC_CHECK); ?>;

        createApp({
            data() {
                return {
                    examTitles: {
                        practice: '{{$examTitles['practice']}}',
                        mistaken: '{{__("Practice Mistakes")}}',
                        real: '{{$examTitles['real']}}',
                    },
                    countOfMistaken: {{$countOfMistaken}},
                    questionCategories: questionCategories,
                    finalResult: {
                        visible: false,
                        message: '',
                        totalQuestions: 0,
                        wrong: 0,
                        percentCorrect: 0,
                        showWrongAnswers: false,
                    },
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
                        duration: 30 * 60,
                        running: '',
                        left: 30 * 60,
                        minutes: 0,
                        seconds: 0,
                    },
                    examConfiguration: {
                        examTitle: '',
                        type: '',
                        numberOfQuestions: 20,
                        showCorrectAnswer: true,
                        categoryID: "-1",
                        showExplanation: false,
                    },
                    loading: {
                        submitExam: false,
                        startReal: false,
                        startPractice: false,
                        startMistaken: false,
                    }
                }
            },
            computed: {},
            methods: {
                openExamConfig(type) {

                    this.examConfiguration.type = type;
                    this.examConfiguration.examTitle = this.examTitles[type];

                    if (type === 'practice') {
                        this.modals.config.visible = true;
                        this.modals.config.error = '';
                    } else {
                        this.startExam();
                    }
                },

                resetExam(forceReset = false) {
                    if (forceReset || confirm("{{__('Resetting the exam will delete your progress. Are you sure you want to proceed?')}}")) {
                        this.exam = [];
                        this.questions = {
                            currentQuestion: 0,
                            allAnswered: false,
                            numberOfAnswered: 0,
                            totalQuestions: 0,
                        };
                        this.timer = {
                            active: false,
                            duration: 40 * 60,
                        };
                        this.finalResult = {
                            visible: false,
                            message: '',
                            totalQuestions: 0,
                            wrong: 0,
                            percentCorrect: 0,
                            showWrongAnswers: false,
                        };
                    }
                },

                reDoExam() {
                    // reset the old answers
                    this.exam.forEach(e => {
                        e.userAnswer = 0;
                    })
                    // reset some properties to their default values
                    this.questions = {
                        currentQuestion: 0,
                        allAnswered: false,
                        numberOfAnswered: 0,
                        totalQuestions: 0,
                    };
                    this.timer = {
                        active: false,
                        duration: 40 * 60,
                    };
                    this.finalResult = {
                        visible: false,
                        message: '',
                        totalQuestions: 0,
                        wrong: 0,
                        percentCorrect: 0,
                        showWrongAnswers: false,
                    };
                },

                startExam() {

                    if (this.examConfiguration.type === 'practice' && this.examConfiguration.categoryID === '') {
                        this.modals.config.error = '{{__('Please select a category.')}}'
                        return;
                    }

                    const vm = this;
                    const token = '{{ auth()->user()->createToken('lol',['get-exam'])->plainTextToken }}';
                    this.loaderController(true);
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
                        .then(res => {
                            console.log(res.data.exam)
                            if (res.data.status === 'failed') {
                                vm.modals.config.error = res.data.message;
                            } else {
                                if (res.data.exam.length > 0) {
                                    // if this is a real exam we need to start the timer
                                    if (vm.examConfiguration.type === 'real') {
                                        vm.startTimer();
                                    }
                                    // add the user's answer property
                                    res.data.exam.forEach(entry => {
                                        entry.userAnswer = 0;
                                    })
                                    vm.questions.totalQuestions = res.data.exam.length;
                                    vm.exam = res.data.exam;
                                }
                                vm.modals.config.visible = false;
                            }
                            vm.loaderController(false);
                        })
                        .catch(error => {
                            console.log(error)
                            if (error.response !== undefined && error.response.data !== undefined && error.response.data.message !== undefined) {
                                vm.modals.config.error = error.response.data.message;
                            } else {
                                vm.modals.config.error = error.message;
                            }
                            vm.loaderController(false);
                        });
                },

                startTimer() {
                    this.timer.active = true;
                    // Get the timer display element
                    const vm = this;

                    let intervalId = setInterval(function () {
                        const minutesText = Math.floor(vm.timer.left / 60).toString().padStart(2, '0');
                        const secondsText = (vm.timer.left % 60).toString().padStart(2, '0');

                        // Update the timer display
                        vm.timer.running = `${minutesText}:${secondsText}`;

                        // Decrement the timer
                        vm.timer.left--;

                        // Check if the timer has finished
                        if (vm.timer.left <= 0) {
                            clearInterval(intervalId);
                            vm.submitExam(true);
                        }
                    }, 1000);
                },

                selectAnswer(answerID) {
                    // check if this is not answered and only then increase the number of Answered questions
                    if (this.exam[this.questions.currentQuestion].userAnswer === 0) {
                        this.questions.numberOfAnswered++
                    }
                    this.exam[this.questions.currentQuestion].userAnswer = answerID;
                    this.questions.allAnswered = (this.questions.numberOfAnswered === this.questions.totalQuestions)
                },

                loaderController(loadingState) {
                    switch (this.examConfiguration.type) {
                        case 'real':
                            this.loading.startReal = loadingState;
                            break;
                        case 'mistaken':
                            this.loading.startMistaken = loadingState;
                            break;
                        default:
                            this.loading.startPractice = loadingState;
                    }
                },

                submitExam(skipQuestionsCheck) {

                    if (!skipQuestionsCheck && !this.questions.allAnswered) {
                        this.modals.info.visible = true;
                        this.modals.info.title = '';
                        this.modals.info.body = '{{__("You need to answer all question.")}}'
                        return;
                    }

                    const vm = this;
                    const token = '{{ auth()->user()->createToken('lol',['get-exam'])->plainTextToken }}';
                    this.loading.submitExam = true;
                    this.calculateFinalResult();

                    axios.defaults.withCredentials = true;

                    axios({
                        url: '/api/v1/submit-exam',
                        method: 'post',
                        data: {
                            exam: this.exam.map(e => {
                                return {
                                    questionId: e.id,
                                    userAnswer: e.userAnswer,
                                    isCorrect: e.userAnswer === e.correct_answer
                                }
                            }),
                            examId: 1,
                            examType: this.examConfiguration.type,
                            results: {
                                score: this.finalResult.percentCorrect,
                                totalQuestions: this.finalResult.totalQuestions,
                                wrong: this.finalResult.wrong
                            }
                        },
                        headers: {
                            Authorization: `Bearer ${token}`,
                            Accept: 'application/json',
                        }
                    })
                        .then(res => {
                            console.log(res.data.exam)
                            vm.loading.submitExam = false;
                            if (res.data.status === 'failed') {
                                vm.modals.info.visible = true;
                                vm.modals.info.body = res.data.message;
                            } else {
                                vm.finalResult.message = res.data.results;
                                vm.finalResult.visible = true;
                            }
                        })
                        .catch(error => {
                            console.log(error)
                            if (error.response !== undefined && error.response.data !== undefined && error.response.data.message !== undefined) {
                                vm.modals.config.error = error.response.data.message;
                            } else {
                                vm.modals.config.error = error.message;
                            }
                            vm.loading.submitExam = false;
                        });
                },

                calculateFinalResult() {
                    const countOfQuestions = this.exam.length;
                    let wrong = 0;
                    for (let question of this.exam) {
                        if (question.userAnswer !== question.correct_answer) {
                            wrong++;
                        }
                    }

                    this.finalResult.totalQuestions = countOfQuestions;
                    this.finalResult.wrong = wrong;
                    this.finalResult.percentCorrect = 100 - Math.round((wrong / countOfQuestions) * 100);
                }
            }
        }).mount('#exam-app')
    </script>

</div>
